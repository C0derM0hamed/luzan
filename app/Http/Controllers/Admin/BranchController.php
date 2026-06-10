<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::query()->orderBy('name')->paginate(15);

        return view('admin.branches.index', [
            'pageTitle' => 'إدارة الفروع',
            'branches' => $branches,
            'tableHeaders' => ['الاسم', 'العنوان', 'الهاتف', 'الحالة', 'إجراءات'],
        ]);
    }

    public function create()
    {
        return view('admin.branches.create', ['pageTitle' => 'إضافة فرع']);
    }

    public function store(Request $request)
    {
        Branch::query()->create($this->validateBranch($request));

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'تم إضافة الفرع بنجاح.');
    }

    public function show(Branch $branch)
    {
        return redirect()->route('admin.branches.edit', $branch);
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', ['pageTitle' => 'تعديل فرع', 'branch' => $branch]);
    }

    public function update(Request $request, Branch $branch)
    {
        $branch->update($this->validateBranch($request));

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'تم تحديث الفرع بنجاح.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'تم حذف الفرع بنجاح.');
    }

    protected function validateBranch(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'map_url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['sometimes', 'boolean'],
        ], [
            'name.required' => 'اسم الفرع مطلوب.',
            'address.required' => 'العنوان مطلوب.',
            'phone.required' => 'رقم الهاتف مطلوب.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        return $validated;
    }
}
