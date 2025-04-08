@extends('layouts.main-walas')

@section('content')
    <div class="w-full bg-gray-100 p-6">
        <h1 class="text-2xl font-bold mb-4">Nilai/Matematika</h1>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <x-tables>
                <table class="w-full border-collapse border rounded-md text-sm" id="table">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">UTS</th>
                            <th class="border p-2">UAS</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td class="border p-2">Yoga</td>
                            <td class="border p-2">0</td>
                            <td class="border p-2">0</td>
                            <td class="border p-2">
                                <div x-data="{ open: false }">
                                    <button @click="open = true" class="text-blue-600 hover:text-blue-800">
                                        ✏️
                                    </button>

                                    <x-modal-nilai title="Input Nilai">
                                        <form action="#" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label
                                                    class="flex justify-start text-sm font-medium mb-1 opacity-50">Nama</label>
                                                <input type="text" name="nama" value="Yoga" readonly
                                                    class="w-full border rounded px-3 py-2 bg-gray-100">
                                            </div>
                                            <div class="mb-4">
                                                <label
                                                    class="flex justify-start text-sm font-medium mb-1 opacity-50">UTS</label>
                                                <input type="number" name="uts" class="w-full border rounded px-3 py-2"
                                                    placeholder="ex: 80" required>
                                            </div>
                                            <div class="mb-4">
                                                <label
                                                    class="flex justify-start text-sm font-medium mb-1 opacity-50">UAS</label>
                                                <input type="number" name="uas" class="w-full border rounded px-3 py-2"
                                                    placeholder="ex: 80" required>
                                            </div>
                                            <div class="flex flex-col justify-center gap-2">
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                                                    Confirm
                                                </button>
                                                <button type="button" @click="open = false"
                                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </x-modal-nilai>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </x-tables>
        </div>
    </div>
@endsection
