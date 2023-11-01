@extends('my_package.layouts.app')

@section('content')
    <section>
        <form action="{{ route('setupCountryCreate') }}" method="post">
            @csrf
            <div class="mb-6 text-left mt-5">
                <label for="countryName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country
                    Name</label>
                <input type="text" required id="countryName" name="countryName"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
            </div>

            <div class="mb-6 text-left mt-5">
                <label for="countryCode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country
                    Code</label>
                <input type="text" required id="countryCode" name="countryCode"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
            </div>
            <button type="submit" class="bg-blue-500 rounded-md text-white px-2 py-1 ">Submit</button>
        </form>
    </section>
@endsection
