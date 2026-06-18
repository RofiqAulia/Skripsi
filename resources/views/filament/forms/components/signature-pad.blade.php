<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $penColor = $field->getPenColor();
        $bgColor = $field->getBackgroundColor();
        $canvasWidth = $field->getWidth();
        $canvasHeight = $field->getHeight();
    @endphp
    <div
        x-data="{
            state: $wire.entangle('{{ $getStatePath() }}'),
            canvas: null,
            ctx: null,
            drawing: false,
            lastX: 0,
            lastY: 0,

            init() {
                this.canvas = this.$refs.canvas;
                this.ctx = this.canvas.getContext('2d');
                this.ctx.strokeStyle = '{{ $penColor }}';
                this.ctx.lineWidth = 2;
                this.ctx.lineCap = 'round';
                this.ctx.lineJoin = 'round';

                if (this.state) {
                    const img = new Image();
                    img.onload = () => {
                        this.ctx.drawImage(img, 0, 0);
                    };
                    img.src = this.state;
                }
            },

            getPos(e) {
                const rect = this.canvas.getBoundingClientRect();
                const scaleX = this.canvas.width / rect.width;
                const scaleY = this.canvas.height / rect.height;

                if (e.touches) {
                    return {
                        x: (e.touches[0].clientX - rect.left) * scaleX,
                        y: (e.touches[0].clientY - rect.top) * scaleY
                    };
                }
                return {
                    x: (e.clientX - rect.left) * scaleX,
                    y: (e.clientY - rect.top) * scaleY
                };
            },

            startDrawing(e) {
                e.preventDefault();
                this.drawing = true;
                const pos = this.getPos(e);
                this.lastX = pos.x;
                this.lastY = pos.y;
            },

            draw(e) {
                if (!this.drawing) return;
                e.preventDefault();
                const pos = this.getPos(e);
                this.ctx.beginPath();
                this.ctx.moveTo(this.lastX, this.lastY);
                this.ctx.lineTo(pos.x, pos.y);
                this.ctx.stroke();
                this.lastX = pos.x;
                this.lastY = pos.y;
            },

            stopDrawing() {
                if (this.drawing) {
                    this.drawing = false;
                    this.save();
                }
            },

            save() {
                this.state = this.canvas.toDataURL('image/png');
            },

            clear() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.state = null;
            }
        }"
        class="signature-pad-wrapper"
    >
        <div style="border: 2px solid #d1d5db; border-radius: 8px; overflow: hidden; display: inline-block; background: {{ $bgColor }}; cursor: crosshair; touch-action: none;">
            <canvas
                x-ref="canvas"
                width="{{ $canvasWidth }}"
                height="{{ $canvasHeight }}"
                style="display: block; width: 100%; max-width: {{ $canvasWidth }}px;"
                @mousedown="startDrawing($event)"
                @mousemove="draw($event)"
                @mouseup="stopDrawing()"
                @mouseleave="stopDrawing()"
                @touchstart="startDrawing($event)"
                @touchmove="draw($event)"
                @touchend="stopDrawing()"
            ></canvas>
        </div>

        <div style="margin-top: 8px; display: flex; gap: 8px;">
            <button
                type="button"
                @click="clear()"
                style="padding: 6px 16px; font-size: 13px; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 6px; cursor: pointer;"
            >
                🗑️ Clear Signature
            </button>
        </div>

        <template x-if="state">
            <div style="margin-top: 10px;">
                <p style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Preview:</p>
                <img :src="state" style="max-height: 80px; border: 1px solid #e5e7eb; border-radius: 4px; padding: 4px; background: #fff;">
            </div>
        </template>
    </div>
</x-dynamic-component>
