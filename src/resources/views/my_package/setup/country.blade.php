@extends('my_package.layouts.app')

@section('content')
    <div class="p-4">
        <div class="text-right mb-3">
            @if (isAllowedPermissions(['menu' => 'country', 'action' => 'create_key']))
                <a href="country/create_key" class="btn btn-sm btn-primary rounded-md text-white">Create <i
                    class="fas fa-plus ml-1 iconSizeEdit"></i></a>
            @endif
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th
                        class="p-3 border border-gray border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        ID</th>
                    <th
                        class="p-3 border border-gray border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Name</th>
                    <th
                        class="p-3 border border-gray border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Country Code</th>

                    <th
                        class="p-3 border border-gray border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($countries as $country)
                    <tr>
                        <td class="p-3 border border-gray border-b border-gray-200 text-sm">{{ $country->id }}</td>
                        <td class="p-3 border border-gray border-b border-gray-200 text-sm">{{ $country->name }}</td>
                        <td class="p-3 border border-gray border-b border-gray-200 text-sm">{{ $country->country_code }}</td>
                        <td class="p-3 border border-gray border-b border-gray-200 text-sm">
                            @if (isAllowedPermissions(['menu'=>'country', 'action'=>'update_key', 'column'=>'permissions']))
                                <a href="country/update_key/{{ $country->id }}"
                                    class="btn btn-sm btn-primary rounded-md text-white"><i class="fas fa-edit iconSizeEdit"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
