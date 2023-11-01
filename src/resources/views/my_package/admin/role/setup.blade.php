@extends('my_package.layouts.app')

@section('content')
    <div class="p-5">
        <form id="RoleUpdateform" method="POST" action="{{ route('roleUpdate') }}" class="bg-white rounded-md">
            @csrf
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h3 class="text-3xl ">User Role</h3>
                <div class="mb-10">
                    <select id="user" name="user"
                        class="form-select mt-1 block p-2 border border-gray-300 rounded-md">
                        <option value="1" selected disabled>Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"> {{ $user->email }} ({{ $user->name }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="tabs" class="d-flex align-items-start">
                <div style="width: 30%; -webkit-box-shadow: 3px 4px 10px -3px rgba(188,180,180,0.75);
                -moz-box-shadow: 3px 4px 10px -3px rgba(188,180,180,0.75);
                margin-right: 40px;" class=" border-gray">
                    <ul class="list-group list-group-flush">
                        @foreach ($menus as $key => $menu)
                            @if ($menu->parent_id == null)
                                <li class="{{ $key == 2 ? 'activeTab' : '' }} text-white px-2 py-2 rounded-sm">
                                    <a class="w-100 d-block tabTitle text-capitalize" href="#tabs-{{ $menu->id }}">{{ $menu->title }}<i
                                            class="fas fa-angle-double-right"></i></a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div style="width: 70%;box-shadow: 3px 4px 10px -3px rgba(188,180,180,0.75);
                -webkit-box-shadow: 3px 4px 10px -3px rgba(188,180,180,0.75);
                -moz-box-shadow: 3px 4px 10px -3px rgba(188,180,180,0.75);"
                    class="p-4">
                    <h4 class="text-3xl mb-4">Permissions: <span class="permissionTitle text-capitalize">Setup</span></h4>
                    @foreach ($menus as $menu)
                        @if ($menu->parent_id == null)
                            <div id="tabs-{{ $menu->id }}">
                                <div class="mb-4 w-full">
                                    <div class="mb-4">
                                        <table class="table">
                                            <thead>
                                                <tr class="" style="background: #0EBEFF; color:white">
                                                    <th class="px-2 py-2 border-0">Title</th>
                                                    @foreach ($menu->children as $child)
                                                        @php
                                                            $permissions = json_decode($child->operations, true);
                                                        @endphp
                                                        @if (!empty($permissions))
                                                            @foreach ($permissions as $permission)
                                                                <th
                                                                    class="text-capitalize px-4 py-2 border border-gray border-top-0 text-center">
                                                                    {{ $permission['title'] }}
                                                                </th>
                                                            @endforeach
                                                        @break
                                                    @endif
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $maxPermissionsCount = 0;
                                                foreach ($menu->children as $child) {
                                                    $permissions = json_decode($child->operations, true);
                                                    $permissionsCount = count($permissions);
                                                    if ($permissionsCount > $maxPermissionsCount) {
                                                        $maxPermissionsCount = $permissionsCount;
                                                    }
                                                }
                                            @endphp

                                            @foreach ($menu->children as $child)
                                                @php
                                                    $permissions = json_decode($child->operations, true);
                                                @endphp
                                                <tr>
                                                    <td class="border border-gray px-1 py-2">{{ $child->title }}</td>
                                                    @if (!empty($permissions))
                                                        @foreach ($permissions as $permission)
                                                            <td class="border border-gray px-4 py-2">
                                                                <input type="checkbox" checked
                                                                    name="{{ $permission['key'] }}[]"
                                                                    value="{{ $child->id }}"
                                                                    class="form-check-input switch_1 mx-auto">
                                                            </td>
                                                        @endforeach
                                                        @for ($i = count($permissions); $i < $maxPermissionsCount; $i++)
                                                            <td class="border border-gray px-4 py-2"></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $maxPermissionsCount; $i++)
                                                            <td class="border border-gray px-4 py-2"></td>
                                                        @endfor
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="text-right mt-5">
            <button type="submit" class="btn" style="background: #0EBEFF; color:white" id="submitBtn">Save</button>
        </div>
    </form>
</div>
</div>

<script>
    $(document).ready(function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'mr-4 btn btn-danger'
            },
            buttonsStyling: false
        })
        $('.tabTitle').click(function() {
            $('.permissionTitle').text($(this).text());
        })

        $('#tabs').tabs({
            activate: function(event, ui) {
                $('#tabs .ui-tabs-nav li').removeClass('activeTab');
                $(ui.newTab).addClass('activeTab');
            }
        });

        $('#user').change(function() {
            var userId = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'get-user-menu-permissions/' + userId,
                beforeSend: function() {
                    $('#submitBtn').text('Processing...').prop('disabled', true);
                },
                success: function(data) {
                    data.forEach(function(permission) {
                        if (permission.permissions) {
                            try {
                                var parsedPermission = JSON.parse(permission
                                    .permissions);
                                data.forEach((array) => {
                                    parsedPermission.forEach((item) => {
                                        var checkbox = $(
                                            'input[name="' +
                                            item.key +
                                            '[]"][value="' +
                                            permission.menu_id +
                                            '"]');
                                        if (checkbox.length) {
                                            checkbox.prop('checked',
                                                item.value ===
                                                true);
                                        }
                                    });
                                });

                            } catch (error) {
                                console.error('Error parsing JSON: ' + error);
                            }
                        }
                    });
                    $('#submitBtn').text('Save').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#submitBtn').text('Save').prop('disabled', false);
                }
            });
        });

        $('#RoleUpdateform').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: form.attr('method'),
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    $('#submitBtn').text('Processing...').prop('disabled', true);
                },
                success: function(response) {
                    swalWithBootstrapButtons.fire(
                            'Success',
                            'Role Updated',
                            'success'
                        )
                    $('#submitBtn').text('Save').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 404) {
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'Please select user',
                            'error'
                        )
                    }
                    $('#submitBtn').text('Save').prop('disabled', false);
                }

            });

        });
    });
</script>



<style>
    /* body {
        background: #F6F8F9;
    } */

    .ui-tabs .ui-tabs-nav li.activeTab {
        background: #0EBEFF;
    }

    .ui-tabs .ui-tabs-nav li a {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
    }

    .ui-tabs .ui-tabs-nav li a:hover {
        text-decoration-line: none;
    }

    .ui-tabs .ui-tabs-nav li.activeTab a {
        color: white;
    }

    .ui-tabs .ui-tabs-nav li:not(.activeTab) {
        background: white;
    }

    .ui-tabs .ui-tabs-nav li:not(.activeTab) a {
        color: black;
    }
</style>
@endsection
