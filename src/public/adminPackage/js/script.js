$('#openCreateModal').click(function() {


    Swal.fire({
        title: 'Create a New Menu',
        text: 'Do you want to continue',
        confirmButtonText: 'Create',
        html: `
<div class="mb-6 text-left mt-5">
<label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
<input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
</div>
<div class="mb-6 text-left">
<label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
<input type="text" id="slug" name="slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
</div>
<div class="mb-6 text-left">
<label for="icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Icon</label>
<input type="text" id="icon" name="icon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
</div>
<div class="mb-6 text-left">
<label for="path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Path</label>
<input type="text" id="path" name="path" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
</div>
<div class="mb-6 text-left">
<label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Level</label>
<input type="text" id="level" name="level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
</div>
`,
        showCancelButton: true,
        preConfirm: () => {
            const title = $('#title').val();
            const slug = $('#slug').val();
            const icon = $('#icon').val();
            const path = $('#path').val();
            const level = $('#level').val();
            const user_id = $('#user_id').val();
            const formData = {
                title: title,
                slug: slug,
                icon: icon,
                path: path,
                level: level,
                user_id: user_id,
                _token: '{{ csrf_token() }}'
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('store.menu') }}",
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Form submitted successfully');
                },
                error: function(error) {
                    console.error('Error submitting the form');
                }
            });
        }
    });

})
$(document).ready(function() {
    $('input[type="checkbox"]').on('change', function() {
        var formData = $('#menu-form').serialize();
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
    $('#nestable').nestable({
        group: 1,
        maxDepth: 3
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

    $('#nestable').on('change', function() {
        var menuOrder = $('#nestable').nestable('serialize');
        var serializedMenu = JSON.stringify(menuOrder);
        console.log(serializedMenu);

        $.ajax({
            type: 'POST',
            url: "{{ route('update.menu.order') }}",
            data: {
                _token: "{{ csrf_token() }}",
                menuOrder: serializedMenu
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    function editMenu(id) {
        $.ajax({
            type: 'GET',
            url: "{{ route('getMenu') }}/" + id,
            success: function(response) {
                const { title, slug, icon, path, level } = response;
                Swal.fire({
                    title: 'Edit Menu',
                    html: `
                        <input type="text" id="title" class="swal2-input" value="${title}" required placeholder="Title">
                        <input type="text" id="slug" class="swal2-input" value="${slug}" required placeholder="Slug">
                        <input type="text" id="icon" class="swal2-input" value="${icon}" required placeholder="Icon">
                        <input type="text" id="path" class="swal2-input" value="${path}" required placeholder="Path">
                        <input type="text" id="level" class="swal2-input" value="${level}" required placeholder="Level">
                    `,
                    showCancelButton: true,
                    preConfirm: () => {
                        const updatedData = {
                            title: $('#title').val(),
                            slug: $('#slug').val(),
                            icon: $('#icon').val(),
                            path: $('#path').val(),
                            level: $('#level').val()
                        };
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('signleMenuUpdate') }}" + id, 
                            data: updatedData,
                            success: function(response) {
                                console.log('Menu updated successfully');
                            },
                            error: function(error) {
                                console.error('Error updating the menu');
                            }
                        });
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching menu data');
            }
        });
    }
    $('#menu-form').on('click', '#edit_menu', function(event) {
        event.preventDefault();
        const menuId = $(this).closest('.dd-item').data('id');
        editMenu(menuId);
    });
});