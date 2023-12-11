<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MercadoPaymentController extends Controller
{

    public $token;
    public $is_enabled;
    public $currancy;
    public $mode;
    protected $invoiceData;

    public function paymentConfig()
    {

//        if(\Auth::check())
//        {
//            $payment_setting = Utility::getAdminPaymentSetting();
//            $this->currancy  = env('CURRENCY');
//        }
//        else
//        {
            $payment_setting = Utility::getCompanyPaymentSetting($this->invoiceData->created_by);
            $this->currancy  = !empty(Utility::getValByName('site_currency')) ? Utility::getValByName('site_currency') : 'USD';

//        }

        $this->token      = isset($payment_setting['mercado_access_token']) ? $payment_setting['mercado_access_token'] : '';
        $this->mode       = isset($payment_setting['mercado_mode']) ? $payment_setting['mercado_mode'] : '';
        $this->is_enabled = isset($payment_setting['is_mercado_enabled']) ? $payment_setting['is_mercado_enabled'] : 'off';

        return $this;
    }



    public function customerPayWithMercado(Request $request)
    {

        $invoiceID = \Illuminate\Support\Facades\Crypt::decrypt($request->invoice_id);
        $invoice   = Invoice::find($invoiceID);

        $this->invoiceData = $invoice;

        $payment = $this->paymentConfig();

        $validatorArray = [
            'amount' => 'required',
            'invoice_id' => 'required',
        ];
        $validator      = Validator::make(
            $request->all(), $validatorArray
        )->setAttributeNames(
            ['invoice_id' => 'Invoice']
        );
        if($validator->fails())
        {
            return redirect()->back()->with('error', __($validator->errors()->first()));
        }



        $user      = User::find($invoice->created_by);
        if($invoice->getDue() < $request->amount)
        {
            return redirect()->back()->with('error', __('Not currect amount'));

        }

        \MercadoPago\SDK::setAccessToken($this->token);
        try
        {

            // Create a preference object
            $preference = new \MercadoPago\Preference();
            // Create an item in the preference
            $item              = new \MercadoPago\Item();
            $item->title       = "Invoice : " . $invoice->invoice_id;
            $item->quantity    = 1;
            $item->unit_price  = (float)$request->amount;
            $preference->items = array($item);

            $success_url             = route(
                'customer.mercado', [
                                      encrypt($invoice->id),
                                      'amount' => (float)$request->amount,
                                      'flag' => 'success',
                                  ]
            );
            $failure_url             = route(
                'customer.mercado', [
                                      encrypt($invoice->id),
                                      'flag' => 'failure',
                                  ]
            );
            $pending_url             = route(
                'customer.mercado', [
                                      encrypt($invoice->id),
                                      'flag' => 'pending',
                                  ]
            );
            $preference->back_urls   = array(
                "success" => $success_url,
                "failure" => $failure_url,
                "pending" => $pending_url,
            );
            $preference->auto_return = "approved";
            $preference->save();

            // Create a customer object
            $payer = new \MercadoPago\Payer();
            // Create payer information
            $payer->name    = $user->name;
            $payer->email   = $user->email;
            $payer->address = array(
                "street_name" => '',
            );

            if($this->mode == 'live')
            {
                $redirectUrl = $preference->init_point;
            }
            else
            {
                $redirectUrl = $preference->sandbox_init_point;
            }

            return redirect($redirectUrl);
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function getInvoicePaymentStatus(Request $request,$invoice_id)
    {

        if(!empty($invoice_id))
        {
            $invoice_id = decrypt($invoice_id);
            $invoice    = Invoice::find($invoice_id);

            $orderID  = strtoupper(str_replace('.', '', uniqid('', true)));
            $settings = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');


            if($invoice && $request->has('status'))
            {
                try
                {

                    if($request->status == 'approved' && $request->flag == 'success')
                    {
                        $payments = InvoicePayment::create(
                            [
                                'invoice_id' => $invoice_id,
                                'date' => date('Y-m-d'),
                                'amount' => $request->has('amount') ? $request->amount : 0,
                                'payment_method' => 1,
                                'order_id' => $orderID,
                                'payment_type' => __('Mercado'),
                                'receipt' => '',
                                'description' => __('Invoice') . ' ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                            ]
                        );

                        $invoice = Invoice::find($invoice->id);


                        if($invoice->getDue() <= 0)
                        {
                            Invoice::change_status($invoice->id, 4);
                        }
                        else
                        {
                            Invoice::change_status($invoice->id, 3);
                        }
                        //for customer balance update
                        Utility::updateUserBalance('customer', $invoice->customer_id, $request->amount, 'debit');


                        //For Notification
                        $setting  = Utility::settingsById($invoice->created_by);
                        $customer = Customer::find($invoice->customer_id);
                        $notificationArr = [
                            'payment_price' => $request->amount,
                            'invoice_payment_type' => 'Mercado',
                            'customer_name' => $customer->name,
                        ];
                        //Slack Notification
                        if(isset($setting['payment_notification']) && $setting['payment_notification'] ==1)
                        {
                            Utility::send_slack_msg('new_invoice_payment', $notificationArr,$invoice->created_by);
                        }
                        //Telegram Notification
                        if(isset($setting['telegram_payment_notification']) && $setting['telegram_payment_notification'] == 1)
                        {
                            Utility::send_telegram_msg('new_invoice_payment', $notificationArr,$invoice->created_by);
                        }

                        //Twilio Notification
                        if(isset($setting['twilio_payment_notification']) && $setting['twilio_payment_notification'] ==1)
                        {
                            Utility::send_twilio_msg($customer->contact,'new_invoice_payment', $notificationArr,$invoice->created_by);
                        }
                        //webhook
                        $module ='New Invoice Payment';
                        $webhook=  Utility::webhookSetting($module,$invoice->created_by);
                        if($webhook)
                        {
                            $parameter = json_encode($invoice);
                            $status = Utility::WebhookCall($webhook['url'],$parameter,$webhook['method']);
                            if($status == true)
                            {
                                return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('success', __(' Payment successfully added.'));
                            }
                            else
                            {
                                return redirect()->back()->with('error', __('Webhook call failed.'));
                            }
                        }


                        return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('success', __(' Payment successfully added.'));

                    }
                    else
                    {
                        return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Transaction fail'));
                    }
                }
                catch(\Exception $e)
                {
                    return redirect()-route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Invoice not found!'));
                }
            }
            else
            {
                return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Invoice not found.'));
            }
        }
        else
        {
            return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice_id))->with('error', __('Invoice not found.'));
        }
    }
}
