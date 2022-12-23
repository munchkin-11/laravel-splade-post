<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Post') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl" dusk="update-profile-information">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Update Posts') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your post's information.") }}
                            </p>
                        </header>

                        <x-splade-form method="put" :action="route('admin.posts.update', $post)" :default="$post" class="mt-6 space-y-6">
                            <x-splade-input id="title" name="title" type="text" :label="__('Title')" required
                                autofocus autocomplete="title" />
                            <x-splade-textarea id="body" name="body" :label="__('Body')" required
                                autocomplete="body" />
                            <x-splade-select name="category_id" :options="$categories" option-label="name" option-value="id"
                                placeholder="Select your category..." />

                            <x-splade-file name="thumbnail" filepond preview :label="__('Thumbnail')" />
                            <div class="flex items-center gap-4">
                                <x-splade-submit :label="__('Save')" />

                                @if (session('status') === 'profile-updated')
                                    <p class="text-sm text-gray-600">
                                        {{ __('Saved.') }}
                                    </p>
                                @endif
                            </div>
                        </x-splade-form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
