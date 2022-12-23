<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-end mb-5">
                <Link href="{{ route('admin.categories.create') }}"
                    class="bg-white hover:bg-gray-100 rounded-md border-2 border-gray-300 shadow-sm w-max py-2 px-4 font-semibold text-gray-800">
                Create
                </Link>
            </div>
            <x-splade-table :for="$categories">
                @cell('status', $category)
                    @if ($category->deleted_at !== null)
                        <span class="font-semibold text-rose-600 hover:text-rose-500">
                            Deleted
                        </span>
                    @else
                        <span class="font-semibold text-emerald-600 hover:text-emerald-500">
                            Active
                        </span>
                    @endif
                @endcell
                @cell('action', $category)
                    <div class="flex items-center divide-x-2">

                        <Link href="{{ route('admin.categories.edit', $category) }}"
                            class="font-semibold text-indigo-600 hover:text-indigo-500 pr-2">
                        Edit
                        </Link>
                        @if ($category->deleted_at == null)
                            <Link href="#confirm-category-deletion" dusk="open-delete-modal"
                                class="font-semibold text-rose-600 hover:text-rose-500 px-2">
                            {{ __('Delete') }}
                            </Link>
                        @endif
                        <x-splade-form :action="route('admin.categories.restore', $category)" method="post" class="px-2">
                            <button class="font-semibold text-blue-600 hover:text-blue-500 ">
                                Restore
                            </button>
                        </x-splade-form>
                        <Link href="#confirm-category-force-deletion" dusk="open-delete-modal"
                            class="font-semibold text-rose-600 hover:text-rose-500 pl-2">
                        {{ __('Force Delete') }}
                        </Link>

                    </div>

                    <x-splade-modal name="confirm-category-deletion">
                        <x-splade-form dusk="confirm-category-deletion" method="delete" :action="route('admin.categories.destroy', $category)">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to delete your this category?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your category is deleted, all of its resources and data will be not permanently deleted. try to restore category again if you need.') }}
                            </p>
                            <div class="mt-6 flex justify-end">
                                <button type="button" @click.prevent="modal.close"
                                    class="inline-flex rounded-md shadow-sm border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                                    {{ __('Cancel') }}
                                </button>

                                <button dusk="confirm-delete-category" type="submit"
                                    class="ml-3 inline-flex rounded-md shadow-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                                    {{ __('Delete Category') }}
                                </button>
                            </div>
                        </x-splade-form>
                    </x-splade-modal>
                    <x-splade-modal name="confirm-category-force-deletion">
                        <x-splade-form dusk="confirm-category-force-deletion" method="delete" :action="route('admin.categories.force', $category)">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to force delete your this category?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your category is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>
                            <div class="mt-6 flex justify-end">
                                <button type="button" @click.prevent="modal.close"
                                    class="inline-flex rounded-md shadow-sm border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                                    {{ __('Cancel') }}
                                </button>

                                <button dusk="confirm-delete-force-category" type="submit"
                                    class="ml-3 inline-flex rounded-md shadow-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                                    {{ __('Force Delete Category') }}
                                </button>
                            </div>
                        </x-splade-form>
                    </x-splade-modal>
                @endcell
            </x-splade-table>
        </div>
    </div>
</x-app-layout>
