<template>
    <div class="settings">
        <div class="card section">
            <h3>Appearance</h3>
            <div class="row">
                <div>
                    <div class="row-title">Theme</div>
                    <div class="row-sub">Choose how TPS looks to you.</div>
                </div>
                <div class="seg">
                    <button :class="{ active: !theme.isDark }" @click="setTheme('light')">☀ Light</button>
                    <button :class="{ active: theme.isDark }" @click="setTheme('dark')">☾ Dark</button>
                </div>
            </div>
        </div>

        <div class="card section">
            <h3>Preferences</h3>
            <div class="row">
                <div>
                    <div class="row-title">Compact tables</div>
                    <div class="row-sub">Reduce row spacing in data tables.</div>
                </div>
                <label class="switch">
                    <input type="checkbox" v-model="compact" />
                    <span class="slider" />
                </label>
            </div>
            <div class="row">
                <div>
                    <div class="row-title">Rows per page</div>
                    <div class="row-sub">Default page size for tables.</div>
                </div>
                <select v-model="pageSize" class="select narrow">
                    <option>10</option><option>25</option><option>50</option>
                </select>
            </div>
        </div>

        <p class="note">Preferences are stored in your browser.</p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useThemeStore } from '../stores/theme';

const theme = useThemeStore();
const compact = ref(localStorage.getItem('tps-compact') === '1');
const pageSize = ref(localStorage.getItem('tps-page-size') || '10');

function setTheme(mode) {
    if ((mode === 'dark') !== theme.isDark) theme.toggle();
}
watch(compact, (v) => localStorage.setItem('tps-compact', v ? '1' : '0'));
watch(pageSize, (v) => localStorage.setItem('tps-page-size', v));
</script>

<style scoped>
.settings { display: flex; flex-direction: column; gap: 1.25rem; max-width: 720px; }
.section { padding: 1.5rem; }
.section h3 { margin-bottom: 1.25rem; }
.row { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.85rem 0; border-top: 1px solid var(--border); }
.row:first-of-type { border-top: none; padding-top: 0; }
.row-title { font-weight: 600; }
.row-sub { color: var(--text-muted); font-size: 0.82rem; }
.narrow { width: 90px; }

.seg { display: inline-flex; background: var(--surface-2); border-radius: var(--radius-sm); padding: 3px; }
.seg button { border: none; background: transparent; padding: 0.4rem 0.8rem; border-radius: 5px; cursor: pointer; color: var(--text-muted); font-weight: 550; }
.seg button.active { background: var(--surface); color: var(--text); box-shadow: var(--shadow-sm); }

.switch { position: relative; display: inline-block; width: 42px; height: 24px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; inset: 0; background: var(--border-strong); border-radius: 999px; transition: 0.2s; cursor: pointer; }
.slider::before { content: ''; position: absolute; height: 18px; width: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: 0.2s; }
.switch input:checked + .slider { background: var(--primary); }
.switch input:checked + .slider::before { transform: translateX(18px); }
.note { color: var(--text-faint); font-size: 0.8rem; }
</style>
