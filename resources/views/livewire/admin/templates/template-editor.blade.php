<div class="flex flex-col h-screen overflow-hidden">

    <!-- 🔷 TOPBAR -->
    <div class="h-12 bg-white border-b flex items-center justify-between px-5">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/favicon.png') }}" class="w-5 h-5">
            <span class="font-semibold text-sm">DOCUMATE</span>
        </div>

        <div class="flex gap-2">
            <button onclick="window.location.href='/admin/templates'"
                class="px-3 py-1 text-xs border rounded-md hover:bg-gray-100 transition">
                ← Back
            </button>

            <button class="px-3 py-1 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Save
            </button>
        </div>
    </div>

    <!-- 🔷 MAIN -->
    <div class="flex flex-1 overflow-hidden"
        x-data="{
            zoom: 100,
            panX: 0,
            panY: 0,
            activeTab: 'field',
            selectedField: null
        }"
    >

        <!-- 🟦 LEFT PANEL -->
        <div class="w-80 bg-white border-r px-4 py-4 overflow-y-auto text-xs">

            <div>

                <!-- UPLOAD (CARD) -->
                <div class="border rounded-lg p-4 text-center mb-3 shadow-sm">

                    <div class="h-40 border-2 border-dashed flex flex-col items-center justify-center text-gray-500 text-xs rounded-md">
                        
                        <!-- IMAGE ICON -->
                        <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16l4-4a3 3 0 014 0l4 4m-4-4l1-1a3 3 0 014 0l2 2M3 16h18"/>
                        </svg>

                        Click to upload
                        <span class="text-[10px] mt-2 text-gray-400">JPG, PNG supported</span>
                    </div>

                    <button class="w-full mt-2 text-xs bg-gray-200 py-1 rounded">
                        Replace Image
                    </button>

                    <!-- WARNING -->
                    <p class="text-[11px] text-yellow-600 mt-2 flex items-center justify-center gap-1">
                        ⚠ Use 300 DPI resolution for best quality
                    </p>
                </div>

                <!-- VIEW -->
                <label class="font-semibold text-xs">View</label>

                <div class="mt-2 space-y-2">
                    <div>
                        <label class="text-[11px] text-gray-500">Zoom</label>
                        <input type="range" min="50" max="150" x-model="zoom" class="w-full">
                    </div>

                    <div>
                        <label class="text-[11px] text-gray-500">Horizontal</label>
                        <input type="range" min="-800" max="800" x-model="panX" class="w-full">
                    </div>

                    <div>
                        <label class="text-[11px] text-gray-500">Vertical</label>
                        <input type="range" min="-800" max="800" x-model="panY" class="w-full">
                    </div>
                </div>

                <hr class="my-4">

                <!-- TEMPLATE -->
                <label class="font-semibold text-xs">Template</label>

                <input type="text"
                    class="w-full border rounded-md px-2 py-1 mt-2"
                    placeholder="Template name">

                <hr class="my-4">

                <!-- PAPER -->
                <label class="font-semibold text-xs">Paper Size</label>

                <div class="grid grid-cols-2 gap-2 my-2 text-[11px]">

                    <div class="border rounded-md p-2 text-center cursor-pointer hover:bg-blue-50">
                        <p class="font-medium">A4</p>
                        <p class="text-gray-400 text-[10px]">21 × 29.7</p>
                    </div>

                    <div class="border rounded-md p-2 text-center cursor-pointer hover:bg-blue-50">
                        <p class="font-medium">Letter</p>
                        <p class="text-gray-400 text-[10px]">8.5 × 11</p>
                    </div>

                    <div class="border rounded-md p-2 text-center cursor-pointer hover:bg-blue-50">
                        <p class="font-medium">A3</p>
                        <p class="text-gray-400 text-[10px]">29.7 × 42</p>
                    </div>

                    <div class="border rounded-md p-2 text-center cursor-pointer hover:bg-blue-50">
                        <p class="font-medium">Legal</p>
                        <p class="text-gray-400 text-[10px]">8.5 × 14</p>
                    </div>

                </div>
                <label class="font-regular text-xs">Custom Size</label>
                <div class="flex gap-2 mt-2 mb-6">
                    <input class="w-1/2 border rounded-md px-2 py-1" placeholder="Width">
                    <input class="w-1/2 border rounded-md px-2 py-1" placeholder="Height">
                </div>

                <label class="font-semibold text-xs">Orientation</label>
                <div class="flex gap-4 mt-2">
                    <label><input type="radio"> Portrait</label>
                    <label><input type="radio"> Landscape</label>
                </div>

            </div>
            <hr class="my-4">

            <!-- TOOLBOX -->
            <label class="font-semibold text-xs">T O O L B O X</label>
            <div class="grid grid-cols-2 gap-3 mt-2 mb-6 text-[11px] text-center">

                <div class="border p-3 cursor-pointer hover:bg-blue-50 rounded"
                     @click="$wire.addField('text')">
                    <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor">
                        <path d="M4 6h16M8 6v12"/>
                    </svg>
                    Text
                </div>

                <div class="border p-3 cursor-pointer hover:bg-blue-50 rounded"
                    @click="$wire.addField('number')">
                    <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor">
                        <path d="M5 10h14M5 14h14"/>
                    </svg>
                    Number
                </div>

                <div class="border p-3 cursor-pointer hover:bg-blue-50 rounded"
                    @click="$wire.addField('paragraph')">
                    <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor">
                        <path d="M4 6h16M4 10h12M4 14h16"/>
                    </svg>
                    Paragraph
                </div>

                <div class="border p-3 cursor-pointer hover:bg-blue-50 rounded"
                    @click="$wire.addField('date')">
                    <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M16 3v4M8 3v4"/>
                    </svg>
                    Date
                </div>

            </div>

        </div>

        <!-- 🟨 CANVAS -->
        <div class=" relative flex-1 bg-gray-100 flex items-center justify-center overflow-hidden" data-canvas>

            <div class="max-w-[900px] max-h-[90%]">

                <div
                    :style="'transform: translate(' + panX + 'px,' + panY + 'px) scale(' + (zoom/100) + ')'"
                    style="transform-origin:center;"
                >

                    <div class="relative bg-white shadow-md" data-editor-canvas
                        style="
                            width: {{ $version->orientation === 'portrait' ? '794px' : '1123px' }};
                            height: {{ $version->orientation === 'portrait' ? '1123px' : '794px' }};
                        ">

                        @if($version && $version->image_path)
                            <img src="/storage/{{ $version->image_path }}"
                                class="absolute inset-0 w-full h-full pointer-events-none">
                        @endif

                        <div class="absolute inset-0 z-10" >
                            {{-- fieldbox --}}
                            @foreach($fields as $field)
                                <div
                                    x-data="fieldInteraction({
                                        index: {{ $field['id'] }},
                                        field: @js($field)
                                    })"
                                    x-init="init()"

                                    @mousedown.prevent="startDrag($event)"
                                    @click.stop="$wire.selectedFieldId = '{{ $field['id'] }}'"

                                    class="absolute bg-white text-xs border cursor-move select-none"
                                    :class="{
                                        'border-blue-500 shadow-sm': '{{ $selectedFieldId }}' === '{{ $field['id'] }}',
                                        'border-gray-300': '{{ $selectedFieldId }}' !== '{{ $field['id'] }}',
                                        'z-50': dragging || resizing
                                    }"

                                    :style="`
                                        left: ${localX}px;
                                        top: ${localY}px;
                                        width: ${localW}px;
                                        height: ${localH}px;
                                    `"
                                >

                                    <!-- CONTENT -->
                                    <div class="w-full h-full px-2 py-1 pointer-events-none">
                                        {{ $field['text'] ?? 'Text' }}
                                    </div>

                                    <!-- CORNERS -->
                                    <div class="absolute w-3 h-3 bg-blue-600 -top-1 -left-1 cursor-nw-resize"
                                        @mousedown.stop.prevent="startResize($event, 'nw')"></div>

                                    <div class="absolute w-3 h-3 bg-blue-600 -top-1 -right-1 cursor-ne-resize"
                                        @mousedown.stop.prevent="startResize($event, 'ne')"></div>

                                    <div class="absolute w-3 h-3 bg-blue-600 -bottom-1 -left-1 cursor-sw-resize"
                                        @mousedown.stop.prevent="startResize($event, 'sw')"></div>

                                    <div class="absolute w-3 h-3 bg-blue-600 -bottom-1 -right-1 cursor-se-resize"
                                        @mousedown.stop.prevent="startResize($event, 'se')"></div>

                                    <!-- EDGES -->
                                    <div class="absolute h-2 w-full top-0 left-0 cursor-n-resize"
                                        @mousedown.stop.prevent="startResize($event, 'n')"></div>

                                    <div class="absolute h-2 w-full bottom-0 left-0 cursor-s-resize"
                                        @mousedown.stop.prevent="startResize($event, 's')"></div>

                                    <div class="absolute w-2 h-full left-0 top-0 cursor-w-resize"
                                        @mousedown.stop.prevent="startResize($event, 'w')"></div>

                                    <div class="absolute w-2 h-full right-0 top-0 cursor-e-resize"
                                        @mousedown.stop.prevent="startResize($event, 'e')"></div>

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- 🟩 RIGHT PANEL -->
        <div class="w-80 bg-white border-l flex flex-col text-xs">

            <!-- TABS -->
            <div class="flex border-b">
                <button class="flex-1 py-2"
                    :class="activeTab==='field' ? 'border-b-2 border-blue-600 font-semibold' : ''"
                    @click="activeTab='field'">
                    Field Settings
                </button>

                <button class="flex-1 py-2"
                    :class="activeTab==='instruction' ? 'border-b-2 border-blue-600 font-semibold' : ''"
                    @click="activeTab='instruction'">
                    Document Instructions
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-3">

                <!-- FIELD SETTINGS -->
                <div x-show="activeTab==='field'">

                    <div class="border rounded-md p-3 mb-3 flex items-center justify-between shadow-sm">

                        <div class="flex items-center gap-2">

                            <!-- ICON BASED ON TYPE -->
                            <template x-if="selectedField === 'text'">
                                <span>🅣</span>
                            </template>

                            <template x-if="selectedField === 'number'">
                                <span>#</span>
                            </template>

                            <template x-if="selectedField === 'paragraph'">
                                <span>¶</span>
                            </template>

                            <template x-if="selectedField === 'date'">
                                <span>📅</span>
                            </template>

                            <div>
                                <div class="font-semibold text-xs">Dynamic Field</div>
                                <div class="text-gray-400 text-[10px]">
                                    Selected: <span x-text="selectedField"></span>
                                </div>
                            </div>

                        </div>

                        <!-- BIG DELETE -->
                        <button class="text-red-500 text-lg hover:scale-110 transition">🗑</button>
                    </div>
                    <label class="font-semibold text-xs">Variable Name</label>
                    <input class="w-full border rounded-md px-2 py-1 mt-1 mb-3" placeholder="@{{variable}}">

                    <hr class="my-3">

                    <label class="font-semibold text-xs">Data Source</label>
                    <div class="mt-1">
                        <label><input type="radio"> System</label>
                        <label class="ml-3"><input type="radio"> User Input</label>
                    </div>

                    <hr class="my-3">
                    {{-- TYPOGRAPHY + STYLING --}}
                    <label class="font-semibold text-xs">Typography</label>

                    <label class="text-[11px] text-gray-500">Font</label>
                    <select class="w-full border rounded-md px-2 py-1 mt-1 mb-2">
                        <option>Arial</option>
                    </select>

                    <div class="flex gap-2">
                        <div class="w-1/2">
                            <label class="text-[11px] text-gray-500">Weight</label>
                            <select class="w-full border rounded-md px-2 py-1">
                                <option>Bold</option>
                            </select>
                        </div>

                        <div class="w-1/2">
                            <label class="text-[11px] text-gray-500">Size</label>
                            <select class="w-full border rounded-md px-2 py-1">
                                <option>28</option>
                            </select>
                        </div>
                    </div>

                    <!-- ALIGNMENT + COLOR -->
                    <div class="flex items-center gap-2 mt-2">

                        <div>
                            <label class="text-[11px] text-gray-500 block">Alignment</label>
                            <div class="flex gap-1 mt-1">

                                <button class="border p-1 rounded">
                                    <svg class="w-4 h-4" stroke="currentColor" fill="none">
                                        <path d="M3 6h12M3 10h8M3 14h12"/>
                                    </svg>
                                </button>

                                <button class="border p-1 rounded">
                                    <svg class="w-4 h-4" stroke="currentColor" fill="none">
                                        <path d="M3 6h12M5 10h8M3 14h12"/>
                                    </svg>
                                </button>

                                <button class="border p-1 rounded">
                                    <svg class="w-4 h-4" stroke="currentColor" fill="none">
                                        <path d="M3 6h12M7 10h8M3 14h12"/>
                                    </svg>
                                </button>

                            </div>
                        </div>

                        <!-- COLOR -->
                        <div class="ml-auto">
                            <label class="text-[11px] text-gray-500 block">Color</label>
                            <div class="flex items-center gap-1 mt-1">
                                <input type="color" class="w-8 h-8 border rounded">
                                <input type="text" value="#000000" class="border px-2 py-1 text-xs w-20">
                            </div>
                        </div>

                    </div>

                    <!-- LINE HEIGHT + LETTER SPACING -->
                    <div class="flex gap-2 mt-2">

                        <div class="w-1/2">
                            <label class="text-[11px] text-gray-500">Line Height</label>
                            <input class="w-full border px-2 py-1 text-xs rounded">
                        </div>

                        <div class="w-1/2">
                            <label class="text-[11px] text-gray-500">Letter Spacing</label>
                            <input class="w-full border px-2 py-1 text-xs rounded">
                        </div>

                    </div>
                    
                    <label class="font-semibold text-xs">Preview Mode</label>
                    <textarea class="w-full border rounded-md mt-1 h-16"></textarea>

                </div>

                <!-- DOCUMENT INSTRUCTIONS -->
                <div x-show="activeTab==='instruction'" class="flex flex-col justify-between h-full">

                    <div>

                        <textarea class="w-full border rounded-md h-20 mb-2"></textarea>

                        <button class="text-xs bg-blue-600 text-white px-3 py-1 rounded-md float-right">
                            + Add Step
                        </button>

                        <div class="mt-6 space-y-3 text-xs">

                            <div class="flex items-center gap-2">

                                <!-- DRAG ICON -->
                                <span class="cursor-move text-gray-400 text-lg">⋮⋮</span>

                                <!-- BOX -->
                                <div class="flex-1 border p-2 rounded flex justify-between items-center">
                                    Step 1: ...
                                </div>

                                <!-- DELETE OUTSIDE -->
                                <button class="text-red-500 text-lg hover:scale-110 transition">🗑</button>

                            </div>

                        </div>

                    </div>

                    <button class="w-full bg-blue-600 text-white py-2 rounded-md mt-2">
                        Save Instructions
                    </button>

                </div>

            </div>

        </div>

    </div>
</div>