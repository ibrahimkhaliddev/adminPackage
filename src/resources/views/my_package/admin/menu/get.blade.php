<div id="nestable" class="dd">
    <ol class="dd-list">
        @foreach ($menus as $menu)
            @if ($menu->parent_id == null)
                <li class="dd-item" data-id="{{ $menu->id }}">
                    <div class="d-flex justify-content-between">
                        <div class="dd-handle" style="text-transform: capitalize">{{ $menu->title }}</div>
                        <div class="switch_box box_1 ml-3">
                            <button id="edit_menu" class="btn btn-sm btn-success ml-1"><i
                                    class="fas fa-edit iconSizeEdit"></i></button>
                            <button id="delete_menu" class="btn btn-sm btn-danger ml-1"><i
                                    class="fas fa-trash iconSizeEdit"></i></button>
                        </div>
                    </div>
                    @if (count($menu->children) > 0)
                        <ol class="dd-list">
                            @foreach ($menu->children as $child)
                                <li class="dd-item" data-id="{{ $child->id }}">
                                    <div class="d-flex justify-content-between">
                                        <div class="dd-handle" style="text-transform: capitalize">
                                            {{ $child->title }}</div>
                                        <div class="switch_box box_1 ml-3">
                                            <button id="edit_menu" class="btn btn-sm btn-success ml-1"><i
                                                    class="fas fa-edit iconSizeEdit"></i></button>
                                            <button id="delete_menu" class="btn btn-sm btn-danger ml-1"><i
                                                    class="fas fa-trash iconSizeEdit"></i></button>
                                        </div>
                                    </div>
                                    @if (count($child->children) > 0)
                                        <ol class="dd-list">
                                            @foreach ($child->children as $subchild)
                                                <li class="dd-item" data-id="{{ $subchild->id }}">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="dd-handle"
                                                            style="text-transform: capitalize">
                                                            {{ $subchild->title }}</div>
                                                        <div class="switch_box box_1 ml-3">
                                                            <button id="edit_menu"
                                                                class="btn btn-sm btn-success ml-1"><i
                                                                    class="fas fa-edit iconSizeEdit"></i></button>
                                                            <button id="delete_menu"
                                                                class="btn btn-sm btn-danger ml-1"><i
                                                                    class="fas fa-trash iconSizeEdit"></i></button>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </li>
            @endif
        @endforeach
    </ol>
</div>