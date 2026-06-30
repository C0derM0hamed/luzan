<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\SvgSanitizer;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()->orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('admin.services.index', [
            'pageTitle' => 'إدارة الخدمات',
            'services' => $services,
            'tableHeaders' => ['الأيقونة', 'الاسم', 'السعر', 'الترتيب', 'الحالة', 'إجراءات'],
        ]);
    }

    public function create()
    {
        return view('admin.services.create', ['pageTitle' => 'إضافة خدمة']);
    }

    public function store(Request $request, SvgSanitizer $svgSanitizer)
    {
        Service::query()->create($this->validateService($request, $svgSanitizer));

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'تم إضافة الخدمة بنجاح.');
    }

    public function show(Service $service)
    {
        return redirect()->route('admin.services.edit', $service);
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', ['pageTitle' => 'تعديل خدمة', 'service' => $service]);
    }

    public function update(Request $request, Service $service, SvgSanitizer $svgSanitizer)
    {
        $service->update($this->validateService($request, $svgSanitizer));

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'تم تحديث الخدمة بنجاح.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'تم حذف الخدمة بنجاح.');
    }

    protected function validateService(Request $request, SvgSanitizer $svgSanitizer): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon_svg' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'اسم الخدمة مطلوب.',
            'icon_svg.required' => 'أيقونة الخدمة مطلوبة.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (int) $request->input('sort_order', 0);
        $validated['icon_svg'] = $svgSanitizer->sanitize($validated['icon_svg']);
        $validated['price'] = $request->filled('price') ? $validated['price'] : null;

        return $validated;
    }
}
