@extends('my_package.layouts.app')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <style>
        .child-ul {
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }

        .child-li {
            opacity: 0;
            transition: opacity 0.2s ease-out;
        }
    </style>

    <div class="container">
        {{-- <div class="bg-gray-500 h-screen w-1/4">
            <ul>
                @foreach ($userMenus as $menu)
                    @if ($menu->parent_id == null && $menu->users->contains($user))
                        <li>
                            @if (count($menu->children) > 0)
                                <a class="text-white border-b w-full block border-gray-100 px-4 py-3 flex justify-between parent-menu"
                                    style="text-transform: capitalize" onclick="toggleChildren(this)">
                                    {{ $menu->title }}
                                    <span class="text-white px-2 cursor-pointer"><i class="fas fa-caret-down"></i></span>
                                </a>
                            @else
                                <a href="{{ $menu->path }}"
                                    class="text-white border-b w-full block border-gray-100 px-4 py-3 flex justify-between parent-menu"
                                    style="text-transform: capitalize" onclick="toggleChildren(this)">
                                    {{ $menu->title }}
                                </a>
                            @endif

                            @if (count($menu->children) > 0)
                                <ul class="child-ul" style="display: none">
                                    @foreach ($menu->children as $child)
                                        @if ($child->users->contains($user))
                                            <li>
                                                @if (count($child->children) > 0)
                                                    <a class="text-white border-b w-full border-gray-100 px-4 py-3 flex justify-between child-menu child-li pl-10"
                                                        style="text-transform: capitalize" onclick="toggleChildren(this)">
                                                        {{ $child->title }}
                                                        <span class="text-white px-2 cursor-pointer"><i
                                                                class="fas fa-caret-down"></i></span>
                                                    </a>
                                                @else
                                                    <a href="{{ $child->path }}"
                                                        class="text-white border-b w-full border-gray-100 px-4 py-3 flex justify-between child-menu child-li pl-10"
                                                        style="text-transform: capitalize" onclick="toggleChildren(this)">
                                                        {{ $child->title }}
                                                    </a>
                                                @endif

                                                @if (count($child->children) > 0)
                                                    <ul class="child-ul" style="display: none">
                                                        @foreach ($child->children as $subchild)
                                                            @if ($subchild->users->contains($user))
                                                                <li>
                                                                    @if (count($subchild->children) > 0)
                                                                        <a class="text-white opacity-1 border-b w-full block border-gray-100 px-4 py-3 subchild-menu child-li pl-20"
                                                                            style="text-transform: capitalize;">
                                                                            {{ $subchild->title }}
                                                                            <span class="text-white px-2 cursor-pointer"><i
                                                                                    class="fas fa-caret-down"></i></span>
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ $subchild->path }}"
                                                                            class="text-white opacity-1 border-b w-full block border-gray-100 px-4 py-3 subchild-menu child-li pl-20"
                                                                            style="text-transform: capitalize;">
                                                                            {{ $subchild->title }}
                                                                        </a>
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div> --}}

    </div>

    <script>
        function toggleChildren(element) {
            var childUl = element.nextElementSibling;
            var childLi = childUl.querySelectorAll('.child-li');
            if (childUl.style.display === 'block') {
                childUl.style.display = 'none';
                for (var i = 0; i < childLi.length; i++) {
                    childLi[i].style.opacity = '0';
                    childLi[i].style.display = 'none';
                    var subUl = childLi[i].querySelector('ul');
                    if (subUl) {
                        subUl.style.display = 'none';
                        var subLi = subUl.querySelectorAll('.child-li');
                        for (var j = 0; j < subLi.length; j++) {
                            subLi[j].style.opacity = '0';
                            subLi[j].style.display = 'none';
                            var doubleSubUl = subLi[j].querySelector('ul');
                            if (doubleSubUl) {
                                doubleSubUl.style.display = 'none';
                            }
                        }
                    }
                }
            } else {
                childUl.style.display = 'block';
                for (var k = 0; k < childLi.length; k++) {
                    childLi[k].style.opacity = '1';
                    childLi[k].style.display = 'flex';
                    var subUl = childLi[k].querySelector('ul');
                    if (subUl) {
                        subUl.style.display = 'block';
                        var subLi = subUl.querySelectorAll('.child-li');
                        for (var l = 0; l < subLi.length; l++) {
                            subLi[l].style.opacity = '1';
                            subLi[l].style.display = 'block';
                            var doubleSubUl = subLi[l].querySelector('ul');
                            if (doubleSubUl) {
                                doubleSubUl.style.display = 'block';
                            }
                        }
                    }
                }
            }
        }
    </script>
@endsection
