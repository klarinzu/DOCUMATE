<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Documate | Template Editor</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen">

    {{ $slot }}

    @livewireScripts
    <script>
        function fieldInteraction(config) {
            return {
                dragging: false,
                resizing: false,
                direction: null,

                zoom: 100,

                offsetX: 0,
                offsetY: 0,

                startX: 0,
                startY: 0,
                startW: 0,
                startH: 0,
                startLeft: 0,
                startTop: 0,

                localX: 100,
                localY: 100,
                localW: 150,
                localH: 50,

                init() {
                    const root = this.$el.closest('[x-data]');
                    this.zoom = root.__x.$data.zoom;

                    this.$watch(() => root.__x.$data.zoom, val => {
                        this.zoom = val;
                    });

                    let field = config.field;

                    // ✅ PREVENT RESET IF ALREADY MOVED
                    if (this.localX === 100 && this.localY === 100) {
                        this.localX = (field.x !== undefined && field.x !== null) ? field.x : 100;
                        this.localY = (field.y !== undefined && field.y !== null) ? field.y : 100;
                        this.localW = (field.width !== undefined && field.width !== null) ? field.width : 150;
                        this.localH = (field.height !== undefined && field.height !== null) ? field.height : 50;
                    }
                },

                getScale() {
                    return this.zoom / 100;
                },

                startDrag(e) {
                    if (this.resizing) return;

                    document.body.style.userSelect = 'none';

                    this.dragging = true;

                    let canvas = document.querySelector('[data-editor-canvas]');
                    let rect = canvas.getBoundingClientRect();
                    let scale = this.getScale();

                    this.offsetX = (e.clientX - rect.left) / scale - this.localX;
                    this.offsetY = (e.clientY - rect.top) / scale - this.localY;

                    this._onDrag = (e) => this.onDrag(e);
                    this._stop = () => this.stopAll();

                    window.addEventListener('mousemove', this._onDrag);
                    window.addEventListener('mouseup', this._stop);
                },

                startResize(e, dir) {
                    e.preventDefault();

                    document.body.style.userSelect = 'none';

                    this.resizing = true;
                    this.direction = dir;

                    let canvas = document.querySelector('[data-editor-canvas]');
                    let rect = canvas.getBoundingClientRect();
                    let scale = this.getScale();

                    this.startX = (e.clientX - rect.left) / scale;
                    this.startY = (e.clientY - rect.top) / scale;

                    this.startW = this.localW;
                    this.startH = this.localH;
                    this.startLeft = this.localX;
                    this.startTop = this.localY;

                    this._onResize = (e) => this.onResize(e);
                    this._stop = () => this.stopAll();

                    window.addEventListener('mousemove', this._onResize);
                    window.addEventListener('mouseup', this._stop);
                },

                onDrag(e) {
                    if (!this.dragging) return;

                    let canvas = document.querySelector('[data-editor-canvas]');
                    let rect = canvas.getBoundingClientRect();
                    let scale = this.getScale();

                    this.localX = (e.clientX - rect.left) / scale - this.offsetX;
                    this.localY = (e.clientY - rect.top) / scale - this.offsetY;
                },

                onResize(e) {
                    if (!this.resizing) return;

                    let canvas = document.querySelector('[data-editor-canvas]');
                    let rect = canvas.getBoundingClientRect();
                    let scale = this.getScale();

                    let dx = ((e.clientX - rect.left) / scale) - this.startX;
                    let dy = ((e.clientY - rect.top) / scale) - this.startY;

                    let newW = this.startW;
                    let newH = this.startH;
                    let newX = this.startLeft;
                    let newY = this.startTop;

                    if (this.direction.includes('e')) newW = this.startW + dx;
                    if (this.direction.includes('w')) {
                        newW = this.startW - dx;
                        newX = this.startLeft + dx;
                    }

                    if (this.direction.includes('s')) newH = this.startH + dy;
                    if (this.direction.includes('n')) {
                        newH = this.startH - dy;
                        newY = this.startTop + dy;
                    }

                    if (newW < 50 || newH < 30) return;

                    this.localW = newW;
                    this.localH = newH;
                    this.localX = newX;
                    this.localY = newY;
                },

                stopAll() {
                    document.body.style.userSelect = '';

                    this.dragging = false;
                    this.resizing = false;

                    this.syncToLivewire();

                    window.removeEventListener('mousemove', this._onDrag);
                    window.removeEventListener('mousemove', this._onResize);
                    window.removeEventListener('mouseup', this._stop);
                },

                syncToLivewire() {
                    let lw = window.Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    );

                    let updatedField = {
                        ...config.field,
                        x: this.localX,
                        y: this.localY,
                        width: this.localW,
                        height: this.localH
                    };

                    config.field = updatedField;

                    lw.set(`fields.${config.index}`, updatedField);
                }
            }
        }
    </script>
</body>
</html>