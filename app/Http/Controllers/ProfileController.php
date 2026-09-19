<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Updates the logged-in user's own profile — mirrors what
     * updateStaffProfileData() already collects in the Account Information
     * form (name, sex/gender, birthday, address/barangay, email, contact).
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sex' => 'nullable|string|max:50',
            'bday' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'contact' => 'nullable|string|max:50',
        ]);

        $user->update([
            'name' => $data['name'],
            'gender' => $data['sex'] ?? $user->gender,
            'dob' => $data['bday'] ?? $user->dob,
            'brgy' => $data['address'] ?? $user->brgy,
            'email' => $data['email'] ?? $user->email,
            'contact' => $data['contact'] ?? $user->contact,
        ]);

        AuditLog::record($user->id, 'update_profile', "{$user->name} updated their own Account Information.");

        return response()->json(['user' => $user->fresh()->toFrontendArray()]);
    }
}
