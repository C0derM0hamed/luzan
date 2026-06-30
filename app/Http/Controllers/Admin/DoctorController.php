<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::query()->with('branches')->orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('admin.doctors.index', [
            'pageTitle' => 'إدارة الأطباء',
            'doctors' => $doctors,
            'tableHeaders' => ['الصورة', 'الاسم', 'التخصص', 'الفروع', 'الترتيب', 'الحالة', 'إجراءات'],
        ]);
    }

    public function create()
    {
        $branches = Branch::query()->where('is_active', true)->orderBy('name')->get();

        return view('admin.doctors.create', [
            'pageTitle' => 'إضافة طبيب',
            'branches' => $branches,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateDoctor($request);
        $branchIds = $request->input('branches', []);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request->file('photo'));
        } elseif ($request->filled('photo_path')) {
            $data['photo'] = $request->input('photo_path');
        }

        $doctor = Doctor::query()->create($data);
        $doctor->branches()->sync($branchIds);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح.');
    }

    public function show(Doctor $doctor)
    {
        return redirect()->route('admin.doctors.edit', $doctor);
    }

    public function edit(Doctor $doctor)
    {
        $branches = Branch::query()->where('is_active', true)->orderBy('name')->get();
        $doctor->load('branches');

        return view('admin.doctors.edit', [
            'pageTitle' => 'تعديل طبيب',
            'doctor' => $doctor,
            'branches' => $branches,
        ]);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $this->validateDoctor($request);
        $branchIds = $request->input('branches', []);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($doctor->photo);
            $data['photo'] = $this->storePhoto($request->file('photo'));
        } elseif ($request->filled('photo_path')) {
            $data['photo'] = $request->input('photo_path');
        }

        $doctor->update($data);
        $doctor->branches()->sync($branchIds);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم تحديث بيانات الطبيب بنجاح.');
    }

    public function destroy(Doctor $doctor)
    {
        $this->deletePhoto($doctor->photo);
        $doctor->delete();

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم حذف الطبيب بنجاح.');
    }

    protected function validateDoctor(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialty' => ['required', 'string', 'max:255'],
            'working_hours' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'branches' => ['nullable', 'array'],
            'branches.*' => ['exists:branches,id'],
        ], [
            'name.required' => 'اسم الطبيب مطلوب.',
            'specialty.required' => 'التخصص مطلوب.',
            'working_hours.required' => 'ساعات العمل مطلوبة.',
            'photo.image' => 'يجب أن تكون الصورة بصيغة صورة صالحة.',
        ]);

        // Remove branches from data since we sync separately
        unset($validated['branches']);

        return $validated + [
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }

    protected function storePhoto($file): string
    {
        $directory = public_path('images/doctors');

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $file->move($directory, $filename);

        return 'doctors/'.$filename;
    }

    protected function deletePhoto(?string $photo): void
    {
        if (! $photo) {
            return;
        }

        $path = public_path('images/'.$photo);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
