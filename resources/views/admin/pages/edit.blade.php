<x-admin-layout>
    <x-slot name="header">Edit Page: {{ $page->title }}</x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Page Title</label>
                    <div class="mt-2">
                        <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium leading-6 text-gray-400">Slug (Read Only)</label>
                    <div class="mt-2">
                        <input type="text" id="slug" value="{{ $page->slug }}" disabled class="block w-full rounded-md border-0 py-1.5 bg-gray-50 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-200 sm:text-sm sm:leading-6 cursor-not-allowed">
                    </div>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium leading-6 text-gray-900">Content (HTML Supported)</label>
                    <div class="mt-2">
                        <textarea name="content" id="content" rows="15" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 font-mono">{{ old('content', $page->content) }}</textarea>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">You can use standard HTML tags for formatting.</p>
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                    <label for="is_active" class="text-sm font-medium text-gray-900">Page is Active</label>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-x-3 border-t border-gray-900/10 pt-6">
                <a href="{{ route('admin.pages.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Save changes</button>
            </div>
        </form>
    </div>
</x-admin-layout>
