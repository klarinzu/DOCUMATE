<div class="space-y-6">

    <!-- 🔵 CURRENT SYSTEM STATUS -->
    <div class="bg-white p-5 rounded-xl shadow border">

        <h2 class="text-lg font-semibold text-gray-700 mb-3">
            System Account Verification Status
        </h2>

        <div class="grid grid-cols-2 gap-4">

            <!-- Semester -->
            <div>
                <p class="text-sm text-gray-500">Current Semester</p>
                <p class="text-xl font-bold text-blue-600">
                    {{ currentSemester() ?? 'Not Set' }}
                </p>
                <p class="text-sm text-gray-400">
                    AY {{ currentAcademicYear() ?? 'Not Set' }}
                </p>
            </div>

            <!-- Verification -->
            <div>
                <p class="text-sm text-gray-500">Verification Status</p>

                @if(isVerificationOpen())
                    <p class="text-green-600 font-semibold text-lg">
                        ✔ OPEN
                    </p>
                    <p class="text-xs text-gray-400">
                        Students can verify accounts
                    </p>
                @else
                    <p class="text-red-600 font-semibold text-lg">
                        ✖ CLOSED
                    </p>
                    <p class="text-xs text-gray-400">
                        Verification is currently disabled
                    </p>
                @endif
                <div class="mt-2 text-xs text-gray-500">
                    @if(systemSetting()?->verification_start_date && systemSetting()?->verification_end_date)
                        {{ \Carbon\Carbon::parse(systemSetting()->verification_start_date)->format('M d, Y') }}
                        →
                        {{ \Carbon\Carbon::parse(systemSetting()->verification_end_date)->format('M d, Y') }}
                    @else
                        Not set
                    @endif
                </div>
            </div>

        </div>

    </div>

    <!-- 🧭 WORKFLOW GUIDE -->
    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl text-sm">

        <p class="font-semibold text-blue-700 mb-2">
            Admin Workflow
        </p>

        <ol class="list-decimal list-inside text-gray-700 space-y-1">
            <li>Set the current semester and academic year</li>
            <li>Define verification period (start and end date)</li>
            <li>Open verification for students</li>
            <li>Students upload e-slip for validation</li>
            <li>System verifies enrollment automatically</li>
        </ol>

    </div>

    <!-- ⚙️ SETTINGS FORM -->
    <div class="bg-white p-5 rounded-xl shadow border">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Update System Account Verification Settings
        </h2>

        {{-- SUCCESS --}}
        @if (session()->has('message'))
            <div class="mb-3 p-3 bg-green-100 text-green-700 rounded">
                ✔ {{ session('message') }}
            </div>
        @endif

        {{-- WARNING --}}
        @if (session()->has('warning'))
            <div class="mb-3 p-3 bg-yellow-100 text-yellow-700 rounded">
                ⚠ {{ session('warning') }}
            </div>
        @endif

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mb-3 p-3 bg-red-100 text-red-700 rounded">
                ✖ Please fix the following:
                <ul class="list-disc ml-5 mt-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (session()->has('message'))
            <script>
                alert("{{ session('message') }}");
            </script>
        @endif

        <form wire:submit.prevent="save" class="space-y-4">

            <div>
                <label class="text-sm text-gray-600">Current Semester</label>
                <select wire:model="current_semester" class="input">
                    <option value="">Select</option>
                    <option>First Semester</option>
                    <option>Second Semester</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Academic Year</label>

                <select wire:model="academic_year" class="input">
                    <option value="">Select Academic Year</option>

                    @php
                        $currentYear = now()->year;
                    @endphp

                    @for($i = $currentYear - 2; $i <= $currentYear + 3; $i++)
                        @php
                            $year = $i . '-' . ($i + 1);
                        @endphp
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor

                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Verification Start</label>
                <input type="date" wire:model="verification_start_date" class="input">
            </div>

            <div>
                <label class="text-sm text-gray-600">Verification End</label>
                <input type="date" wire:model="verification_end_date" class="input">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Settings
            </button>

        </form>

    </div>
    <script>
        window.addEventListener('alert', event => {

            let type = event.detail.type;
            let message = event.detail.message;

            let color = {
                success: '#16a34a',
                error: '#dc2626',
                warning: '#f59e0b'
            }[type];

            // remove old toasts
            document.querySelectorAll('.custom-toast').forEach(el => el.remove());

            let div = document.createElement('div');
            div.innerText = message;
            div.classList.add('custom-toast');

            div.style.position = 'fixed';
            div.style.top = '20px';
            div.style.right = '20px';
            div.style.padding = '12px 16px';
            div.style.background = color;
            div.style.color = 'white';
            div.style.borderRadius = '8px';
            div.style.zIndex = '9999';
            div.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';

            document.body.appendChild(div);

            setTimeout(() => div.remove(), 3000);
        });
        </script>   

</div>