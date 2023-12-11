<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\UserCoupon;
use Exception;
use Illuminate\Http\Request;
use App\Models\Utility;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ToyyibpayController extends Controller
{
    public $secretKey, $callBackUrl, $returnUrl, $categoryCode, $is_enabled, $invoiceData;

//    public function __construct()
//    {
//
//        $payment_setting = Utility::getAdminPaymentSetting();
//
//
//        $this->secretKey = isset($payment_setting['toyyibpay_secret_key']) ? $payment_setting['toyyibpay_secret_key'] : '';
//        $this->categoryCode = isset($payment_setting['category_code']) ? $payment_setting['category_code'] : '';
//        $this->is_enabled = isset($payment_setting['is_toyyibpay_enabled']) ? $payment_setting['is_toyyibpay_enabled'] : 'off';
//    }

    public function paymentConfig()
    {
        $payment_setting = Utility::getCompanyPaymentSetting($this->invoiceData->created_by);
        $this->secretKey = isset($payment_setting['toyyibpay_secret_key']) ? $payment_setting['toyyibpay_secret_key'] : '';
        $this->categoryCode                = isset($payment_setting['toyyibpay_category_code']) ? $payment_setting['toyyibpay_category_code'] : '';
        $this->is_enabled          = isset($payment_setting['is_toyyibpay_enabled']) ? $payment_setting['is_toyyibpay_enabled'] : 'off';
        return $this;
    }


    public function index()
    {
        return view('payment');
    }

    public function invoicepaywithtoyyibpay(Request $request)
    {
        // dd($request->all());
        $invoiceID = \Illuminate\Support\Facades\Crypt::decrypt($request->invoice_id);
        $invoice = Invoice::find($invoiceID);
        $this->invoiceData = $invoice;
        $user      = User::find($invoice->created_by);
        $payment   = $this->paymentConfig();
        $settings  = DB::table('settings')->where('created_by', '=',$invoice->created_by)->get()->pluck('value', 'name');
        $get_amount = $request->amount;

        if ($invoice)
        {
            if ($get_amount > $invoice->getDue())
            {
                return redirect()->back()->with('error', __('Invalid amount.'));
            } else
            {
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                $name = Utility::invoiceNumberFormat($settings, $invoice->invoice_id);
                $this->callBackUrl = route('customer.toyyibpay', [$invoice->id, $get_amount]);
                $this->returnUrl = route('customer.toyyibpay', [$invoice->id, $get_amount]);

            }
            $Date = date('d-m-Y');
            $ammount = $get_amount;
            $billExpiryDays = 3;
            $billExpiryDate = date('d-m-Y', strtotime($Date . ' + 3 days'));
            $billContentEmail = "Thank you for purchasing our product!";
            $some_data = array(
                'userSecretKey' => $this->secretKey,
                'categoryCode' => $this->categoryCode,
                'billName' => "invoice",
                'billDescription' => "invoice",
                'billPriceSetting' => 1,
                'billPayorInfo' => 1,
                'billAmount' => 100 * $ammount,
                'billReturnUrl' => $this->returnUrl,
                'billCallbackUrl' => $this->callBackUrl,
                'billExternalReferenceNo' => 'AFR341DFI',
                'billTo' => $user->name,
                'billEmail' => $user->email,
                'billPhone' => '0000000000',
                'billSplitPayment' => 0,
                'billSplitPaymentArgs' => '',
                'billPaymentChannel' => '0',
                'billContentEmail' => $billContentEmail,
                'billChargeToCustomer' => 1,
                'billExpiryDate' => $billExpiryDate,
                'billExpiryDays' => $billExpiryDays,
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
            $result = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            $obj = json_decode($result);

            if($get_amount != 0)
            {
                if(!empty($obj)) {
                    return redirect('https://toyyibpay.com/' . $obj[0]->BillCode);
                }
            }

            return redirect()->route('invoice.link.copy', \Crypt::encrypt($invoice->id))->with('error', __('Please enter valid amount'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getInvoicePaymentStatus(Request $request, $invoice_id, $amount)
    {
//         dd($request->all(),$invoice_id, $amount);

        $invoice = Invoice::find($invoice_id);
        $this->invoiceData = $invoice;
        $settings  = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');
        $payment_id = \Session::get('PayerID');
        \Session::forget('PayerID');
        if (empty($request->PayerID || empty($request->token))) {
            return redirect()->back()->with('error', __('Payment failed'));
        }
        $orderID  = strtoupper(str_replace('.', '', uniqid('', true)));
        try
        {
            if ($request->status_id == 3)
            {
                return redirect()->route('invoice.link.copy', \Crypt::encrypt($invoice->id))->with('error', __('Your Transaction is fail please try again'));
            }
            else if ($request->status_id == 2)
            {
                return redirect()->route('invoice.link.copy', \Crypt::encrypt($invoice->id))->with('error', __('Your Transaction on pending'));
            }
            else if ($request->status_id == 1)
            {
                $payments = InvoicePayment::create(
                    [

                        'invoice_id' => $invoice->id,
                        'date' => date('Y-m-d'),
                        'amount' => $amount,
                        'account_id' => 0,
                        'payment_method' => 0,
                        'order_id' => $orderID,
                        'payment_type' => __('Toyyibpay'),
                        'receipt' => '',
                        'reference' => '',
                        'description' => 'Invoice ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                    ]
                );

                $invoicePayment              = new \App\Models\Transaction();
                $invoicePayment->user_id     = $invoice->customer_id;
                $invoicePayment->user_type   = 'Customer';
                $invoicePayment->type        = 'Toyyibpay';
                $invoicePayment->created_by  = \Auth::check() ? \Auth::user()->id : $invoice->customer_id;
                $invoicePayment->payment_id  = $invoicePayment->id;
                $invoicePayment->category    = 'Invoice';
                $invoicePayment->amount      = $amount;
                $invoicePayment->date        = date('Y-m-d');
                $invoicePayment->created_by  = \Auth::check() ? \Auth::user()->creatorId() : $invoice->created_by;
                $invoicePayment->payment_id  = $payments->id;
                $invoicePayment->description = 'Invoice ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id);
                $invoicePayment->account     = 0;
                \App\Models\Transaction::addTransaction($invoicePayment);

                //for customer balance update
                Utility::updateUserBalance('customer', $invoice->customer_id, $request->amount, 'debit');


                //For Notification
                $setting  = Utility::settingsById($invoice->created_by);
                $customer = Customer::find($invoice->customer_id);
                $notificationArr = [
                    'payment_price' => $request->amount,
                    'invoice_payment_type' => 'Toyyibpay',
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
                    $parameter = json_encode($invoicePayment);
                    $status = Utility::WebhookCall($webhook['url'],$parameter,$webhook['method']);
                    if($status == true)
                    {
                        return redirect()->route('invoice.link.copy', \Crypt::encrypt($invoice->id))->with('error', __('Transaction has been failed.'));
                    }
                    else
                    {
                        return redirect()->back()->with('error', __('Webhook call failed.'));
                    }
                }

                if (\Auth::check()) {
                    return redirect()->route('invoice.link.copy', \Crypt::encrypt($invoice->id))->with('error', __('Transaction has been failed.'));
                } else
                {
                    return redirect()->back()->with('success', __(' Payment successfully added.'));
                }

            }
        }
        catch (\Exception $e)
        {
            if (\Auth::check())
            {
                return redirect()->route('invoice.link.copy', \Crypt::encrypt($invoice->id))->with('error', __('Transaction has been failed.'));
            } else
            {
                return redirect()->back()->with('success', __('Transaction has been completed.'));
            }
        }
    }
}
