<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('user')->paginate(10);
        return view('lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('lecturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|unique:lecturers',
            'full_name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'academic_degree' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'lecturer',
            ]);

            Lecturer::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'full_name' => $request->full_name,
                'specialization' => $request->specialization,
                'academic_degree' => $request->academic_degree,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);
        });

        return redirect()->route('lecturers.index')
            ->with('success', 'Lecturer created successfully.');
    }

    public function show(Lecturer $lecturer)
    {
        $lecturer->load('user', 'courses');
        return view('lecturers.show', compact('lecturer'));
    }

    public function edit(Lecturer $lecturer)
    {
        $lecturer->load('user');
        return view('lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $lecturer->user_id,
            'nip' => 'required|string|unique:lecturers,nip,' . $lecturer->id,
            'full_name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'academic_degree' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
        ]);

        DB::transaction(function () use ($request, $lecturer) {
            $lecturer->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $lecturer->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $lecturer->update([
                'nip' => $request->nip,
                'full_name' => $request->full_name,
                'specialization' => $request->specialization,
                'academic_degree' => $request->academic_degree,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);
        });

        return redirect()->route('lecturers.index')
            ->with('success', 'Lecturer updated successfully.');
    }

    public function destroy(Lecturer $lecturer)
    {
        DB::transaction(function () use ($lecturer) {
            $user = $lecturer->user;
            $lecturer->delete();
            $user->delete();
        });

        return redirect()->route('lecturers.index')
            ->with('success', 'Lecturer deleted successfully.');
    }
}
