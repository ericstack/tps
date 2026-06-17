<template>
    <div class="ss" :class="{ open }">
        <input
            ref="inputEl"
            v-model="query"
            class="input"
            :placeholder="placeholder"
            @focus="onFocus"
            @blur="onBlur"
            @keydown.down.prevent="move(1)"
            @keydown.up.prevent="move(-1)"
            @keydown.enter.prevent="choose(filtered[highlight])"
            @keydown.esc="close"
        />
        <span v-if="modelValue" class="ss-clear" @mousedown.prevent="clear" aria-label="Clear">×</span>
        <ul v-if="open && filtered.length" class="ss-menu card">
            <li
                v-for="(opt, i) in filtered"
                :key="opt.value"
                class="ss-item"
                :class="{ active: i === highlight, selected: opt.value === modelValue }"
                @mousedown.prevent="choose(opt)"
                @mousemove="highlight = i"
            >
                {{ opt.label }}
            </li>
        </ul>
        <ul v-else-if="open" class="ss-menu card">
            <li class="ss-empty">No matches</li>
        </ul>
    </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    modelValue: { type: [String, Number, null], default: null },
    options: { type: Array, default: () => [] },
    placeholder: { type: String, default: 'Search…' },
});
const emit = defineEmits(['update:modelValue', 'change']);

const query = ref('');
const open = ref(false);
const highlight = ref(0);
const inputEl = ref(null);

const selectedLabel = computed(() => props.options.find((o) => o.value === props.modelValue)?.label ?? '');

// Keep the input text in sync with the selected value when not actively searching.
watch(selectedLabel, (label) => { if (!open.value) query.value = label; }, { immediate: true });

const filtered = computed(() => {
    const q = query.value.trim().toLowerCase();
    if (!q || query.value === selectedLabel.value) return props.options;
    return props.options.filter((o) => o.label.toLowerCase().includes(q));
});

function onFocus() {
    open.value = true;
    query.value = '';
    highlight.value = 0;
}
function onBlur() {
    close();
}
function close() {
    open.value = false;
    query.value = selectedLabel.value; // restore selected label
}
function choose(opt) {
    if (!opt) return;
    emit('update:modelValue', opt.value);
    emit('change', opt.value);
    query.value = opt.label;
    open.value = false;
    inputEl.value?.blur();
}
function clear() {
    emit('update:modelValue', null);
    emit('change', null);
    query.value = '';
}
function move(dir) {
    if (!open.value) { open.value = true; return; }
    const n = filtered.value.length;
    if (!n) return;
    highlight.value = (highlight.value + dir + n) % n;
}
</script>

<style scoped>
.ss { position: relative; }
.ss-clear {
    position: absolute; right: 0.6rem; top: 50%; transform: translateY(-50%);
    color: var(--text-muted); cursor: pointer; font-size: 1.1rem; line-height: 1;
}
.ss-menu {
    position: absolute; z-index: 10; top: calc(100% + 4px); left: 0; right: 0;
    max-height: 220px; overflow-y: auto; padding: 0.3rem; margin: 0; list-style: none;
    box-shadow: var(--shadow-md, 0 8px 24px rgba(0,0,0,0.18));
}
.ss-item {
    padding: 0.5rem 0.6rem; border-radius: var(--radius-sm); cursor: pointer;
    font-size: 0.85rem; color: var(--text);
}
.ss-item.active { background: var(--surface-hover); }
.ss-item.selected { color: var(--primary); font-weight: 600; }
.ss-empty { padding: 0.6rem; color: var(--text-muted); font-size: 0.85rem; }
</style>
