<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberCertificateController extends Controller
{
    public function index()
    {
        // Get the authenticated member (assuming your Member model is linked to User)
        $member = Auth::user()->member;
        
        // Get certificates that have been issued to this member
        $certificates = $member->certificates()
            ->with(['signatories'])
            ->orderBy('certificate_member.issued_at', 'desc')
            ->paginate(12);
            
        return view('member.certificates.index', compact('certificates'));
    }

    public function show(Certificate $certificate)
    {
        $member = Auth::user()->member;
        
        // Verify the member has this certificate
        if (!$member->certificates()->where('certificate_id', $certificate->id)->exists()) {
            abort(403, 'You do not have access to this certificate');
        }
        
        // Get the issuance details
        $issuedAt = $member->certificates()
            ->where('certificate_id', $certificate->id)
            ->first()
            ->pivot
            ->issued_at;
            
        return view('member.certificates.show', [
            'certificate' => $certificate,
            'member' => $member,
            'issuedAt' => $issuedAt
        ]);
    }
    
    public function previewContent(Certificate $certificate)
    {
        $member = Auth::user()->member;
        
        // Verify the member has this certificate
        if (!$member->certificates()->where('certificate_id', $certificate->id)->exists()) {
            abort(403, 'You do not have access to this certificate');
        }
        
        // Get the issuance details
        $issuedAt = $member->certificates()
            ->where('certificate_id', $certificate->id)
            ->first()
            ->pivot
            ->issued_at;
            
        return view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => $issuedAt,
            'embedded' => true
        ]);
    }
}