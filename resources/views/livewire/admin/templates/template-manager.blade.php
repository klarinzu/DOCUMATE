<div class="relative">

    <!-- MAIN CONTENT -->
    <div class="flex h-full">

        <div class="flex-1 p-2">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-xl font-bold">DocuMate Templates</h1>
                    <p class="text-xs text-gray-500">
                        Manage VPSD document templates
                    </p>
                </div>

                <button wire:click="openPanel"
                    class="bg-blue-600 text-white px-3 py-1.5 text-sm rounded-md hover:bg-blue-700 transition">
                    + Add Template
                </button>
            </div>

            <!-- TEMPLATE GRID -->
            <div class="grid grid-cols-4 gap-4">

                @forelse($templates as $template)
                    <div class="bg-white rounded-lg shadow-sm border overflow-hidden hover:shadow-md transition">

                        <!-- IMAGE -->
                        <div class="h-32 bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if($template->currentVersion && $template->currentVersion->image_path)
                                <img 
                                    src="{{ asset('storage/' . $template->currentVersion->image_path) }}"
                                    class="object-cover w-full h-full"
                                >
                            @else
                                <span class="text-gray-400 text-xs">No Preview</span>
                            @endif
                        </div>

                        <!-- CONTENT -->
                        <div class="p-3">

                            <h2 class="font-semibold text-xs mb-1">
                                {{ $template->name }}
                            </h2>

                            <p class="text-[11px] text-gray-500 mb-2">
                                @if($template->currentVersion)
                                    {{ $template->currentVersion->document_size }} • 
                                    {{ ucfirst($template->currentVersion->orientation) }}
                                @else
                                    No version yet
                                @endif
                            </p>

                            <div class="flex gap-1">

                                <button
                                    wire:click="editTemplate({{ $template->template_id }})"
                                    class="flex-1 text-[11px] bg-blue-600 text-white py-1 rounded hover:bg-blue-700 transition">
                                    Edit
                                </button>

                                <button
                                    class="flex-1 text-[11px] border py-1 rounded hover:bg-gray-100 transition">
                                    Versions
                                </button>

                            </div>

                        </div>
                    </div>

                @empty
                    <div class="col-span-4 text-center text-gray-500 text-sm">
                        No templates created yet.
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div
        class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg transform transition-transform duration-300 z-50
        {{ $showPanel ? 'translate-x-0' : 'translate-x-full' }}"
    >
        <div class="p-4 flex flex-col h-full">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-base font-semibold">Add Template</h2>
                <button wire:click="closePanel"
                    class="text-gray-500 hover:text-black text-lg">
                    ✕
                </button>
            </div>

            <!-- FORM -->
            <div class="space-y-4 flex-1 overflow-y-auto pr-1">

                <!-- UPLOAD -->
                <div>
                    <label class="text-xs font-semibold">Upload Document Image</label>

                    <label class="mt-1 flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400 mb-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5V19a2 2 0 002 2h14a2 2 0 002-2v-2.5M16 12l-4-4m0 0L8 12m4-4v12" />
                            </svg>

                            <p class="text-xs text-gray-600">Click to upload</p>
                            <p class="text-[11px] text-gray-400">PNG, JPG up to 2MB</p>
                        </div>

                        <input type="file" wire:model="image" class="hidden">
                    </label>

                    <p class="text-[11px] text-yellow-600 mt-1">
                        Use high quality image (300 DPI recommended)
                    </p>

                    @error('image') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror

                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="mt-2 rounded border">
                    @endif
                </div>

                <hr>

                <!-- TEMPLATE NAME -->
                <div>
                    <label class="text-xs font-semibold">
                        Template Name <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                        wire:model="name"
                        placeholder="Enter name..."
                        class="w-full border rounded-md px-2 py-1.5 mt-1 text-sm
                        @error('name') border-red-500 @enderror">

                    @error('name')
                        <span class="text-red-500 text-[11px]">{{ $message }}</span>
                    @enderror
                </div>

                <hr>

                <!-- PAPER SIZE -->
                <div>
                    <label class="text-xs font-semibold">Paper Size</label>

                    <div class="grid grid-cols-2 gap-2 mt-1">

                        <!-- A4 -->
                        <div wire:click="$set('paper_size','A4'); $set('custom_width', null); $set('custom_height', null)"
                            class="cursor-pointer border rounded-md p-2 text-center text-xs
                            {{ $paper_size === 'A4' ? 'border-blue-600 bg-blue-50' : '' }}">
                            <p class="font-medium text-xs">A4</p>
                            <p class="text-[10px] text-gray-500">21 x 29.7 cm</p>
                        </div>

                        <!-- LETTER -->
                        <div wire:click="$set('paper_size','Letter'); $set('custom_width', null); $set('custom_height', null)"
                            class="cursor-pointer border rounded-md p-2 text-center text-xs
                            {{ $paper_size === 'Letter' ? 'border-blue-600 bg-blue-50' : '' }}">
                            <p class="font-medium text-xs">Letter</p>
                            <p class="text-[10px] text-gray-500">8.5 x 11 in</p>
                        </div>

                        <!-- A3 -->
                        <div wire:click="$set('paper_size','A3'); $set('custom_width', null); $set('custom_height', null)"
                            class="cursor-pointer border rounded-md p-2 text-center text-xs
                            {{ $paper_size === 'A3' ? 'border-blue-600 bg-blue-50' : '' }}">
                            <p class="font-medium text-xs">A3</p>
                            <p class="text-[10px] text-gray-500">29.7 x 42 cm</p>
                        </div>

                        <!-- LEGAL -->
                        <div wire:click="$set('paper_size','Legal'); $set('custom_width', null); $set('custom_height', null)"
                            class="cursor-pointer border rounded-md p-2 text-center text-xs
                            {{ $paper_size === 'Legal' ? 'border-blue-600 bg-blue-50' : '' }}">
                            <p class="font-medium text-xs">Legal</p>
                            <p class="text-[10px] text-gray-500">8.5 x 14 in</p>
                        </div>

                    </div>

                    <!-- CUSTOM -->
                    <div class="mt-2
                        {{ (!$paper_size && ($custom_width || $custom_height)) ? 'border border-blue-600 bg-blue-50 p-2 rounded-md' : '' }}">
                        
                        <label class="text-[11px] text-gray-500">Custom Size</label>

                        <div class="flex gap-2 mt-1">
                            <input type="number"
                                wire:model="custom_width"
                                wire:focus="$set('paper_size', null)"
                                placeholder="Width"
                                class="w-1/2 border rounded px-2 py-1 text-xs">

                            <input type="number"
                                wire:model="custom_height"
                                wire:focus="$set('paper_size', null)"
                                placeholder="Height"
                                class="w-1/2 border rounded px-2 py-1 text-xs">
                        </div>
                    </div>
                </div>

                <hr>

                <!-- ORIENTATION -->
                <div>
                    <label class="text-xs font-semibold">Orientation</label>

                    <div class="flex gap-4 mt-1 text-sm">
                        <label class="flex items-center gap-1">
                            <input type="radio" wire:model="orientation" value="portrait">
                            Portrait
                        </label>

                        <label class="flex items-center gap-1">
                            <input type="radio" wire:model="orientation" value="landscape">
                            Landscape
                        </label>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="pt-3 border-t">
                <button wire:click="save"
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white py-2 rounded-md text-sm hover:bg-blue-700 transition">
                    ✔ Create Template
                </button>
            </div>

        </div>
    </div>

</div>