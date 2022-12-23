<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-end mb-5">
                <Link href="{{ route('admin.posts.create') }}"
                    class="bg-white hover:bg-gray-100 rounded-md border-2 border-gray-300 shadow-sm w-max py-2 px-4 font-semibold text-gray-800">
                Create
                </Link>
            </div>
            <x-splade-table :for="$posts">
                @cell('thumbnail', $post)
                    <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}"
                        class="w-10 h-10 object-cover object-center rounded-full">
                @endcell
                @cell('action', $post)
                    <div class="flex items-center space-x-2">

                        <Link href="{{ route('admin.posts.edit', $post) }}"
                            class="font-semibold text-blue-600 hover:text-blue-500">
                        Edit
                        </Link>
                        <Link href="#confirm-post-deletion" dusk="open-delete-modal"
                            class="font-semibold text-rose-600 hover:text-rose-500">
                        {{ __('Delete') }}
                        </Link>
                    </div>

                    <x-splade-modal name="confirm-post-deletion">
                        <x-splade-form dusk="confirm-post-deletion" method="delete" :action="route('admin.posts.destroy', $post)">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to delete your this post?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your post is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>
                            <div class="mt-6 flex justify-end">
                                <button type="button" @click.prevent="modal.close"
                                    class="inline-flex rounded-md shadow-sm border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                                    {{ __('Cancel') }}
                                </button>

                                <button dusk="confirm-delete-account" type="submit"
                                    class="ml-3 inline-flex rounded-md shadow-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                                    {{ __('Delete Post') }}
                                </button>
                            </div>
                        </x-splade-form>
                    </x-splade-modal>
                @endcell
            </x-splade-table>
        </div>
    </div>
</x-app-layout>
