<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use App\Models\Member;
use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Traits\ApiResponser;

class ApiController extends Controller
{
    use ApiResponser;
    public function membersdetails($memberno)
    {

        $member = Member::where('MemberNo', $memberno)->first();
        Log::info($member);
        $loan = Member::select(
            "members.*",
            "loan_applications.*"
        )
            ->join("loan_applications", "members.MemberNo", "=", "loan_applications.MemberNo")
            ->where('members.MemberNo', "=", $memberno)->first();

        Log::info($loan);
        // foreach($loans as $loan)
        Log::info($loan);

        if ($loan) {
            return response()->json(
                [
                    'success' => true,
                    'member' => $member,
                    'loan' => $loan
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => true,
                    'member' => $member,

                ]
            );
        }
    }
    public function store(Request $request)
    {
        $userid = $request->MemberNo;
        // if (LoanApplication::where('MemberNo', '=', $request->IdNumber)->exists()) {
        // }
        $count =  DB::table('loan_applications')
            ->select(DB::raw('count(*) as count'))
            ->where('MemberNo', $userid)
            ->where('LoanCode', '=', $request->LoanCode)
            ->get();
        if ($count) {
            foreach ($count as $loan_count) {
                $newcount = $loan_count->count + 1;
                $loan_number = $request->LoanCode . $userid . '-' . $newcount;
                Log::info($loan_number);
            }
        }
        $loans_check = Member::select('*')
            ->where('loan_applications', $userid)
            ->where('Approved', 0)
            ->get();
        if ($loans_check) {
            foreach ($loans_check as $loan_checks) {
                $Pendingapproval = $loans_check->AmountApplied;
            }

            if ($Pendingapproval > 0) {
                Alert::error('Loan Balance', 'Your Have Pending Loans to be Approved: ' );
                // return $this->([
                //     'loan' => $loan,
                //     'message' => 'Successfully Applied'
                // ]);
                redirect()->back();
            }
        }
        else
        {
        $loanlimiamt = DB::table('members')->where('MemberNo', $userid)->pluck('MaxLoan')->sum();
        $amount = DB::table('loan_applications')->where('MemberNo', $userid)->pluck('ApprovedAmount')->sum();
        $amountpendingapproval = DB::table('loan_applications')->where('MemberNo', $userid)->pluck('AmountApplied')->sum();
        $payment = DB::table('repayments')->where('MemberNo', $userid)->pluck('amount')->sum();
        $balance = $amount - $payment;
        // $balance = $ApprovedAmount-$RepaidAmount;
        // Log::info($payment);
        // Log::info($amount);
        // Log::info($balance);
        $zero = 0;

        if ($balance > 0) {
            Alert::error('Loan Balance', 'Your Have Pending Loans: ' . strtoupper($balance) . ' ' . '');
            Log::info($balance);
            redirect()->back();
        }

        $Rperiod = $request->Rperiod;
        //$loanlimit = ($deposit) * 3;
        $loanlimit = $request->LoanLimit;
        Log::info($Rperiod);
        Log::info($loanlimit);

        $loanapplied = $request->AmountApplied;

        $loan = new LoanApplication;
        $loan->MemberNo = $userid;
        $loan->Loanno = $loan_number;
        $loan->LoanCode = $request->LoanCode;
        $loan->AmountApplied = $request->AmountApplied;
        $loanApplied = $request->AmountApplied;
        $loan->ApplicationDate = Carbon::now()->format('Y-m-d');;
        $loan->EffectDate = Carbon::now()->format('Y-m-d');
        $loan->RecoverInterestFirst = true;
        $loan->IntRate = $request->IntRate;
        $loan->Rperiod = $request->Rperiod;
        $loan->Createdby = $request->Name;
        $loan->Approved = false;
        $loan->ApprovedAmount = '0';
        $loan->RepayAmount = '0';
        $loan->IsDisbursed = false;
        $loan->ApprovedBy = $request->ApprovedBy;
        $loan->Modifiedby = $request->Modifiedby;
        $loan->ApprovedOn = $request->ApprovedOn;
        $loan->save();
        return $this->success([
            'loan' => $loan,
            'message' => 'Successfully Applied'
        ]);
    
        $members_check = Member::select('*')->where('MemberNo', $userid)->get();
        foreach ($members_check as $members_checks) {
            $phone = $members_checks->KinMobile;
            $clientnames = $members_checks->Name;
            $Names = $members_checks->KinName;
            $message = 'Dear ' . $Names . ',' . $clientnames . ' has applied for a loan of KES:' . $loanApplied . ' at Vanlin Investments ltd and Choosen you as Next of Kin, regards Vanlin.0710418966';
            Log::info($Names);
            Log::info($phone);

            $createsms = new SMS;
            $createsms->phone = $phone;
            $createsms->message = $message;
            $createsms->rType = 'json';
            $createsms->status = 0;
            $createsms->save();
            SMS::Sendsms();
            //  Alert::success('Loan Application', 'You\'ve Successfully Applied');
        }
    }
    }
}
