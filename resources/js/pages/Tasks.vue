<template>
    <CrudTable ref="table" title="Tasks" endpoint="/api/tasks" :columns="columns" :fields="fields">
        <!-- per-row "open" button to view details, comment, and change status -->
        <template #row-actions="{ row }">
            <button class="btn btn-ghost btn-icon" @click="open(row)" aria-label="Open" title="Comments & status">
                <span v-html="chatIcon" />
            </button>
        </template>

        <!-- detail drawer -->
        <transition name="fade">
            <div v-if="active" class="modal-backdrop" @click.self="close">
                <div class="drawer card">
                    <div class="drawer-head">
                        <div>
                            <h3>{{ active.subject }}</h3>
                            <p class="assignee">
                                {{ active.employee ? active.employee.employee_name : 'Unassigned' }}
                            </p>
                        </div>
                        <button class="btn btn-ghost btn-icon" @click="close">×</button>
                    </div>

                    <div class="drawer-body">
                        <p v-if="active.description" class="desc">{{ active.description }}</p>
                        <p v-else class="desc muted">No description.</p>

                        <label class="field status-field">
                            <span>Status</span>
                            <select v-if="canManage" v-model="status" class="select" @change="changeStatus">
                                <option v-for="s in statuses" :key="s" :value="s">{{ s }}</option>
                            </select>
                            <span v-else class="badge">{{ active.status }}</span>
                        </label>

                        <h4 class="comments-title">Comments</h4>
                        <p v-if="commentsError" class="error">{{ commentsError }}</p>
                        <div class="comments">
                            <div v-for="c in comments" :key="c.id" class="comment">
                                <div class="comment-head">
                                    <strong>{{ authorName(c) }}</strong>
                                    <span class="when">{{ formatWhen(c.created_at) }}</span>
                                </div>
                                <p class="comment-body">{{ c.body }}</p>
                            </div>
                            <p v-if="!comments.length" class="muted">No comments yet.</p>
                        </div>

                        <form v-if="canManage" class="add-comment" @submit.prevent="addComment">
                            <textarea
                                v-model="newComment"
                                class="input"
                                rows="2"
                                placeholder="Write a comment…"
                            />
                            <button class="btn btn-primary" :disabled="!newComment.trim()">Comment</button>
                        </form>
                        <p v-else class="muted readonly-note">Only the assigned employee or an admin can comment or change status.</p>
                    </div>
                </div>
            </div>
        </transition>
    </CrudTable>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import CrudTable from '../components/CrudTable.vue';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();

// Admins manage any task; otherwise only the user linked to the assigned employee.
const canManage = computed(() =>
    !!active.value && (
        auth.isAdmin ||
        (auth.user?.employee_id != null && auth.user.employee_id === active.value.employee_id)
    ),
);

const statuses = ['open', 'in progress', 'done'];

const columns = [
    { key: 'subject', label: 'Subject' },
    { key: 'employee.employee_name', label: 'Assigned To' },
    { key: 'due_date', label: 'Due' },
    { key: 'status', label: 'Status' },
];

const employeeOptions = ref([]);

const fields = computed(() => [
    { key: 'subject', label: 'Subject' },
    { key: 'description', label: 'Description', type: 'textarea' },
    { key: 'assigned_date', label: 'Assigned Date', type: 'date' },
    { key: 'due_date', label: 'Due Date', type: 'date' },
    { key: 'employee_id', label: 'Employee', options: employeeOptions.value, searchable: true },
    { key: 'status', label: 'Status', default: 'open', options: statuses.map((s) => ({ value: s, label: s })) },
]);

const table = ref(null);
const active = ref(null);
const status = ref('open');
const comments = ref([]);
const commentsError = ref('');
const newComment = ref('');

async function open(row) {
    active.value = row;
    status.value = row.status;
    comments.value = [];
    commentsError.value = '';
    newComment.value = '';
    try {
        const { data } = await window.axios.get(`/api/tasks/${row.id}/comments`);
        comments.value = data;
    } catch (e) {
        commentsError.value = e.response?.data?.message || 'Failed to load comments.';
    }
}
function close() {
    active.value = null;
}

async function changeStatus() {
    try {
        await window.axios.patch(`/api/tasks/${active.value.id}/status`, { status: status.value });
        active.value.status = status.value;
        table.value?.reload();
    } catch (e) {
        commentsError.value = e.response?.data?.message || 'Failed to update status.';
        status.value = active.value.status; // revert the select
    }
}

async function addComment() {
    const body = newComment.value.trim();
    if (!body) return;
    try {
        const { data } = await window.axios.post(`/api/tasks/${active.value.id}/comments`, { body });
        comments.value.unshift(data);
        newComment.value = '';
    } catch (e) {
        commentsError.value = e.response?.data?.message || 'Failed to add comment.';
    }
}

function authorName(c) {
    return c.user?.name || c.user?.username || 'Unknown';
}
function formatWhen(iso) {
    if (!iso) return '';
    const d = new Date(iso);
    return `${d.toLocaleDateString()} ${d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
}

onMounted(async () => {
    const { data } = await window.axios.get('/api/employees', { params: { per_page: 1000 } });
    const employees = data.data ?? data;
    employeeOptions.value = employees.map((e) => ({
        value: e.id,
        label: `${e.employee_code} — ${e.employee_name}`,
    }));
});

const chatIcon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>';
</script>

<style scoped>
.drawer { width: 480px; max-width: 100%; max-height: 90vh; display: flex; flex-direction: column; }
.drawer-head { display: flex; align-items: flex-start; justify-content: space-between; padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); }
.drawer-head h3 { margin: 0; }
.assignee { margin: 0.2rem 0 0; font-size: 0.82rem; color: var(--text-muted); }
.drawer-body { padding: 1.25rem; overflow-y: auto; display: flex; flex-direction: column; gap: 1rem; }
.desc { margin: 0; color: var(--text); }
.muted { color: var(--text-muted); }
.field { display: flex; flex-direction: column; gap: 0.35rem; font-size: 0.82rem; font-weight: 550; color: var(--text-muted); }
.status-field { max-width: 220px; }
.comments-title { margin: 0.25rem 0 0; font-size: 0.95rem; }
.comments { display: flex; flex-direction: column; gap: 0.75rem; }
.comment { background: var(--surface-2); border-radius: var(--radius-sm); padding: 0.6rem 0.75rem; }
.comment-head { display: flex; justify-content: space-between; align-items: baseline; gap: 0.5rem; }
.comment-head strong { font-size: 0.85rem; }
.when { font-size: 0.72rem; color: var(--text-faint); }
.comment-body { margin: 0.3rem 0 0; font-size: 0.88rem; white-space: pre-wrap; }
.add-comment { display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end; }
.add-comment textarea { width: 100%; resize: vertical; }
.error { color: var(--danger); background: var(--danger-soft); padding: 0.5rem 0.7rem; border-radius: var(--radius-sm); margin: 0; }
.readonly-note { font-size: 0.8rem; }
</style>
