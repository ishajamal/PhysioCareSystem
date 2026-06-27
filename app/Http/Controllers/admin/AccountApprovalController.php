<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\TherapistApprovedMail;
use Illuminate\Support\Facades\Mail;

class AccountApprovalController extends Controller
{
    public function index()
    {
        $therapists = User::where('role', 'therapist')
            ->where('is_approved', false)
            ->get();

        return view('admin.ApprovalAccount.account-approval', compact('therapists'));
    }

    public function approve($id)
    {
        $therapist = User::findOrFail($id);

        $therapist->is_approved = true;
        $therapist->save();

        Mail::to($therapist->email)
            ->send(new TherapistApprovedMail($therapist));

        return redirect()->back()
            ->with('success', 'Account approved successfully and email has been sent.');
    }
}