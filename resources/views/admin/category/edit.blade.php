<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl" dusk="update-profile-information">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Update Category') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Update your categories information..') }}
                            </p>
                        </header>

                        <x-splade-form method="put" :action="route('admin.categories.update', $category)" :default="$category" class="mt-6 space-y-6">
                            <x-splade-input id="name" name="name" type="text" :label="__('Name')" required
                                autofocus autocomplete="name" />

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
