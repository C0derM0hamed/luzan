<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::query()->latest()->paginate(15);

        return view('admin.offers.index', [
            'pageTitle' => 'إدارة العروض',
            'offers' => $offers,
            'tableHeaders' => ['الصورة', 'العنوان', 'تاريخ البداية', 'تاريخ النهاية', 'الحالة', 'إجراءات'],
        ]);
    }

    public function create()
    {
        return view('admin.offers.create', ['pageTitle' => 'إضافة عرض']);
    }

    public function store(Request $request)
    {
        $data = $this->validateOffer($request);

        if ($request->hasFile('image')) {
            \App\Services\UploadValidationService::validate($request->file('image'), ['jpg', 'jpeg', 'png', 'webp', 'gif'], 'image');
            $data['image'] = $this->storeImage($request->file('image'));
        }

        Offer::query()->create($data);

        return redirect()
            ->route('admin.offers.index')
            ->with('success', 'تم إضافة العرض بنجاح.');
    }

    public function show(Offer $offer)
    {
        return redirect()->route('admin.offers.edit', $offer);
    }

    public function edit(Offer $offer)
    {
        return view('admin.offers.edit', ['pageTitle' => 'تعديل عرض', 'offer' => $offer]);
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $this->validateOffer($request);

        if ($request->hasFile('image')) {
            \App\Services\UploadValidationService::validate($request->file('image'), ['jpg', 'jpeg', 'png', 'webp', 'gif'], 'image');
            $this->deleteImage($offer->image);
            $data['image'] = $this->storeImage($request->file('image'));
        }

        $offer->update($data);

        return redirect()
            ->route('admin.offers.index')
            ->with('success', 'تم تحديث العرض بنجاح.');
    }

    public function destroy(Offer $offer)
    {
        $this->deleteImage($offer->image);
        $offer->delete();

        return redirect()
            ->route('admin.offers.index')
            ->with('success', 'تم حذف العرض بنجاح.');
    }

    protected function validateOffer(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'file', 'max:2048'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_active' => ['sometimes', 'boolean'],
        ], [
            'title.required' => 'عنوان العرض مطلوب.',
            'description.required' => 'وصف العرض مطلوب.',
            'start_date.required' => 'تاريخ البداية مطلوب.',
            'end_date.required' => 'تاريخ النهاية مطلوب.',
            'end_date.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        return $validated;
    }

    protected function storeImage($file): string
    {
        $directory = public_path('images/offers');

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $file->move($directory, $filename);

        return 'offers/'.$filename;
    }

    protected function deleteImage(?string $image): void
    {
        if (! $image) {
            return;
        }

        $path = public_path('images/'.$image);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
