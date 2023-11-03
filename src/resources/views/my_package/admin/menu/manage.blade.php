@extends('my_package.layouts.app')
@section('content')

    <section class="flex">
        <div class="container mx-auto text-center py-5">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="text-3xl mb-4">User Menu</h3>
                <select id="userSelect" class="form-select mt-1 block p-2 border border-gray-300 rounded-md">
                    <option value="1" selected disabled>Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"> {{ $user->email }} ({{ $user->name }})</option>
                    @endforeach
                </select>
            </div>

            <style>
                .child-menu-1 {
                    /* padding-left: 60px !important; */
                }

                .child-menu-2 {
                    padding-left: 80px;
                }

                #menu-form table tr td,
                th {
                    padding: 7px 10px !important;
                    text-transform: capitalize;
                }

                .form-switch.box_1 {
                    justify-content: center;
                    display: flex;
                }
                .form-check{
                    padding: 0px !important;
                }
            </style>

            <form action="{{ route('update.menus') }}" method="POST" class="mt-5 w-100 text-left rounded-md" id="menu-form">
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <div class="topBg" style="display: none;"><img src="{{ asset('adminPackage/spinner.gif') }}" alt=""></div>
                <table class="table border border-gray">
                    <thead>
                        <tr style="background: #F2F2F2">
                            <th width="90%">Title</th>
                            <th>Checked</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            @if ($menu->parent_id == null)
                                <tr>
                                    <td>{{ $menu->title }}</td>
                                    <td>
                                        <div class="form-check form-switch box_1 ms-3">
                                            <input type="checkbox" checked name="menus[]" value="{{ $menu->id }}"
                                                class="form-check-input switch_1">
                                        </div>
                                    </td>
                                </tr>
                                @if (count($menu->children) > 0)
                                    @foreach ($menu->children as $child)
                                        <tr>
                                            <td class="child-menu-1">{{ $child->title }}</td>
                                            <td>
                                                <div class="form-check form-switch box_1 ms-3">
                                                    <input type="checkbox" checked name="menus[]"
                                                        value="{{ $child->id }}" class="form-check-input switch_1">
                                                </div>
                                            </td>
                                        </tr>
                                        @if (count($child->children) > 0)
                                            @foreach ($child->children as $subchild)
                                                <tr>
                                                    <td class="child-menu-2">{{ $subchild->title }}</td>
                                                    <td>
                                                        <div class="form-check form-switch box_1 ms-3">
                                                            <input type="checkbox" checked name="menus[]"
                                                                value="{{ $subchild->id }}"
                                                                class="form-check-input switch_1">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </form>

        </div>
    </section>
    <script>
        $('input[type="checkbox"]').on('change', function() {
            var formData = $('#menu-form').serialize();
            console.log(formData)
            $.ajax({
                type: 'POST',
                url: $('#menu-form').attr('action'),
                data: formData,

                success: function(response) {
                    console.log('Form submitted successfully');
                },
                error: function(error) {
                    console.error('Error submitting the form');
                }
            });
        });

        $('#userSelect').change(function() {
            var userId = $(this).val();
            $('.topBg').show();
            $('input[type="checkbox"]').prop('checked', false);
            if (userId !== '') {
                $.ajax({
                    url: '/admin/get-user-menus/' + userId,
                    type: 'GET',
                    success: function(data) {
                        console.log(data)
                        $('#user_id').val(userId);
                        $('#userMenus').empty();
                        data.forEach(function(menu) {
                            $('input[value="' + menu.id + '"]').prop('checked',
                                true);
                        });
                        $('.topBg').hide();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                $('#userMenus').html('');
            }
        });
    </script>
@endsection
