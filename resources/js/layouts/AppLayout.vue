<template>
    <div class="shell">
        <!-- Sidebar -->
        <aside class="sidebar" :class="{ open: mobileOpen }">
            <div class="brand">
                <span class="brand-mark">T</span>
                <span class="brand-name">TPS</span>
            </div>
            <nav class="nav">
                <router-link v-for="item in visibleNav" :key="item.name" :to="{ name: item.name }" class="nav-link" @click="mobileOpen = false">
                    <span class="nav-ico" v-html="item.icon" />
                    <span>{{ item.label }}</span>
                </router-link>
                <router-link v-if="auth.isAdmin" :to="{ name: 'users' }" class="nav-link" @click="mobileOpen = false">
                    <span class="nav-ico" v-html="icons.users" />
                    <span>Users</span>
                </router-link>
            </nav>
        </aside>

        <!-- Main -->
        <div class="main">
            <header class="topbar">
                <button class="btn btn-ghost btn-icon menu-btn" @click="mobileOpen = !mobileOpen" aria-label="Menu">
                    <span v-html="icons.menu" />
                </button>
                <div class="page-title">{{ currentTitle }}</div>
                <div class="topbar-actions">
                    <button class="btn btn-ghost btn-icon" @click="theme.toggle()" :aria-label="theme.isDark ? 'Light mode' : 'Dark mode'">
                        <span v-html="theme.isDark ? icons.sun : icons.moon" />
                    </button>

                    <!-- User dropdown -->
                    <div class="user-menu" ref="menuRef">
                        <button class="user-trigger" @click="menuOpen = !menuOpen">
                            <span class="avatar">{{ initials }}</span>
                            <span class="user-meta">
                                <span class="user-name">{{ auth.user?.name }}</span>
                                <span class="user-role">{{ roleLabel }}</span>
                            </span>
                            <span class="chev" v-html="icons.chevron" />
                        </button>
                        <transition name="pop">
                            <div v-if="menuOpen" class="dropdown card">
                                <div class="dropdown-head">
                                    <span class="avatar lg">{{ initials }}</span>
                                    <div>
                                        <div class="user-name">{{ auth.user?.name }}</div>
                                        <div class="user-sub">{{ auth.user?.username }}</div>
                                    </div>
                                </div>
                                <div class="dropdown-sep" />
                                <button class="dropdown-item" @click="go('profile')">
                                    <span v-html="icons.user" /> Profile
                                </button>
                                <button class="dropdown-item" @click="go('settings')">
                                    <span v-html="icons.cog" /> Settings
                                </button>
                                <button class="dropdown-item" @click="go('change-password')">
                                    <span v-html="icons.user" /> Change password
                                </button>
                                <div class="dropdown-sep" />
                                <button class="dropdown-item danger" @click="logout">
                                    <span v-html="icons.logout" /> Log out
                                </button>
                            </div>
                        </transition>
                    </div>
                </div>
            </header>

            <main class="content">
                <router-view />
            </main>
        </div>

        <div v-if="mobileOpen" class="backdrop" @click="mobileOpen = false" />
    </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useThemeStore } from '../stores/theme';

const auth = useAuthStore();
const theme = useThemeStore();
const router = useRouter();
const route = useRoute();

const menuOpen = ref(false);
const mobileOpen = ref(false);
const menuRef = ref(null);

const icons = {
    dashboard: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>',
    box: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M3.27 6.96 12 12.01l8.73-5.05"/><path d="M12 22.08V12"/></svg>',
    tag: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 13.42 20.6a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5"/></svg>',
    users: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    cart: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
    check: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
    truck: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
    file: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
    contact: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>',
    menu: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
    moon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>',
    sun: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>',
    chevron: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>',
    user: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
    cog: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
    logout: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>',
};

const nav = [
    { name: 'dashboard', label: 'Dashboard', icon: icons.dashboard, hide: 'dashboard' },
    { name: 'inventory', label: 'Inventory', icon: icons.box, module: 'inventory_products' },
    { name: 'products', label: 'Products', icon: icons.tag, module: 'inventory_products' },
    { name: 'customers', label: 'Customers', icon: icons.contact, hide: 'customers' },
    { name: 'employees', label: 'Employees', icon: icons.users, hide: 'employees' },
    { name: 'orders', label: 'Orders', icon: icons.cart, module: 'orders' },
    { name: 'deliveries', label: 'Deliveries', icon: icons.truck, module: 'deliveries' },
    { name: 'purchase-orders', label: 'Purchase Orders', icon: icons.file, module: 'purchase_orders' },
];

// Hide gated modules the role can't access, plus open modules hidden per-role.
const visibleNav = computed(() =>
    nav.filter((item) => (!item.module || auth.can(item.module)) && !(item.hide && auth.isHidden(item.hide)))
);

const roleLabels = {
    admin: 'Administrator',
    manager: 'Manager',
    deliveries: 'Deliveries',
    orders: 'Orders',
    warehouse: 'Warehouse',
    staff: 'Staff',
};
const roleLabel = computed(() => roleLabels[auth.role] || 'User');

const currentTitle = computed(() => {
    const found = nav.find((n) => n.name === route.name);
    if (found) return found.label;
    return ({ users: 'Users', profile: 'Profile', settings: 'Settings', 'change-password': 'Change Password' })[route.name] || 'TPS';
});

const initials = computed(() => {
    const n = auth.user?.name || auth.user?.username || '?';
    return n.split(' ').map((p) => p[0]).slice(0, 2).join('').toUpperCase();
});

function go(name) {
    menuOpen.value = false;
    router.push({ name });
}

async function logout() {
    menuOpen.value = false;
    await auth.logout();
    router.push({ name: 'login' });
}

function onClickOutside(e) {
    if (menuRef.value && !menuRef.value.contains(e.target)) menuOpen.value = false;
}
onMounted(() => document.addEventListener('click', onClickOutside));
onBeforeUnmount(() => document.removeEventListener('click', onClickOutside));
</script>

<style scoped>
.shell { display: flex; min-height: 100vh; }

/* Sidebar */
.sidebar {
    width: 248px;
    flex-shrink: 0;
    background: var(--surface);
    border-right: 1px solid var(--border);
    padding: 1rem 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    position: sticky;
    top: 0;
    height: 100vh;
}
.brand { display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem 0.6rem; }
.brand-mark {
    width: 32px; height: 32px; display: grid; place-items: center;
    background: var(--primary); color: #fff; border-radius: 9px; font-weight: 700;
}
.brand-name { font-size: 1.1rem; font-weight: 700; letter-spacing: -0.02em; }
.nav { display: flex; flex-direction: column; gap: 2px; }
.nav-link {
    display: flex; align-items: center; gap: 0.7rem;
    padding: 0.6rem 0.65rem; border-radius: var(--radius-sm);
    color: var(--text-muted); font-weight: 500;
    transition: background-color 0.12s, color 0.12s;
}
.nav-link:hover { background: var(--surface-hover); color: var(--text); }
.nav-link.router-link-exact-active { background: var(--primary-soft); color: var(--primary); font-weight: 600; }
.nav-ico { display: inline-flex; }

/* Main */
.main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
.topbar {
    position: sticky; top: 0; z-index: 20;
    display: flex; align-items: center; gap: 1rem;
    padding: 0.75rem 1.5rem;
    background: color-mix(in srgb, var(--surface) 80%, transparent);
    backdrop-filter: blur(8px);
    border-bottom: 1px solid var(--border);
}
.page-title { font-size: 1.05rem; font-weight: 650; }
.topbar-actions { margin-left: auto; display: flex; align-items: center; gap: 0.6rem; }
.menu-btn { display: none; }

/* User menu */
.user-menu { position: relative; }
.user-trigger {
    display: flex; align-items: center; gap: 0.6rem;
    padding: 0.3rem 0.5rem 0.3rem 0.35rem;
    background: transparent; border: 1px solid transparent; border-radius: 999px;
    cursor: pointer; color: var(--text);
}
.user-trigger:hover { background: var(--surface-hover); }
.avatar {
    width: 34px; height: 34px; border-radius: 50%;
    display: grid; place-items: center;
    background: var(--primary); color: #fff; font-weight: 650; font-size: 0.8rem; flex-shrink: 0;
}
.avatar.lg { width: 40px; height: 40px; font-size: 0.9rem; }
.user-meta { display: flex; flex-direction: column; line-height: 1.15; text-align: left; }
.user-name { font-weight: 600; font-size: 0.85rem; }
.user-role, .user-sub { font-size: 0.72rem; color: var(--text-muted); }
.chev { color: var(--text-muted); display: inline-flex; }

.dropdown {
    position: absolute; right: 0; top: calc(100% + 8px);
    width: 230px; padding: 0.5rem; box-shadow: var(--shadow-lg); z-index: 30;
}
.dropdown-head { display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem; }
.dropdown-sep { height: 1px; background: var(--border); margin: 0.35rem 0; }
.dropdown-item {
    display: flex; align-items: center; gap: 0.6rem; width: 100%;
    padding: 0.55rem 0.5rem; border: none; background: transparent; cursor: pointer;
    color: var(--text); border-radius: var(--radius-sm); font-size: 0.85rem; text-align: left;
}
.dropdown-item:hover { background: var(--surface-hover); }
.dropdown-item.danger { color: var(--danger); }
.dropdown-item.danger:hover { background: var(--danger-soft); }

.content { padding: 1.5rem; flex: 1; }

.pop-enter-active, .pop-leave-active { transition: opacity 0.12s, transform 0.12s; }
.pop-enter-from, .pop-leave-to { opacity: 0; transform: translateY(-4px) scale(0.98); }

.backdrop { display: none; }

@media (max-width: 860px) {
    .sidebar {
        position: fixed; z-index: 50; left: 0; top: 0; transform: translateX(-100%);
        transition: transform 0.2s ease; box-shadow: var(--shadow-lg);
    }
    .sidebar.open { transform: translateX(0); }
    .menu-btn { display: inline-flex; }
    .user-meta { display: none; }
    .backdrop { display: block; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 40; }
}
</style>
