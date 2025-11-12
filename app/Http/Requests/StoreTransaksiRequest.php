<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_user'            => 'required|exists:users,id',
            'id_kamar'           => 'required|exists:kamars,id',
            'tanggal_pembayaran' => 'required|date',
            'periode_pembayaran' => 'required|string|max:20',
            'masuk_kamar'        => 'nullable|date',
            'durasi'             => 'required|string|max:20',
            'total_bayar'        => 'required|numeric|min:1000', // Minimal Rp 1.000
            'metode_pembayaran'  => 'required|in:cash,midtrans'
        ];
    }

    public function messages()
    {
        return [
            'id_user.required'           => 'Pilih user/pelanggan terlebih dahulu',
            'id_kamar.required'          => 'Pilih kamar terlebih dahulu',
            'total_bayar.required'       => 'Total bayar harus diisi',
            'total_bayar.min'            => 'Total bayar minimal Rp 1.000',
            'metode_pembayaran.required' => 'Metode pembayaran harus dipilih'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Bersihkan format currency sebelum validasi
        if ($this->has('total_bayar')) {
            $this->merge([
                'total_bayar' => str_replace('.', '', $this->total_bayar)
            ]);
        }
    }
}
