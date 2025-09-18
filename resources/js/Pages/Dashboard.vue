<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  contracts: Object, // Laravel paginator { data, links, ... }
  filters: Object
})

const onSearch = (e) => {
  e.preventDefault()
  const params = new URLSearchParams(new FormData(e.target))
  router.get('/dashboard', Object.fromEntries(params), {
    preserveState: true,
    replace: true,
  })
}
</script>

<template>
  <section style="max-width: 1000px; margin: 24px auto; padding: 0 12px;">
    <header style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
      <h1 style="font-size:1.5rem;">Contracts</h1>
      <a href="/contracts/create" style="padding:8px 12px;border:1px solid #ddd;border-radius:8px;text-decoration:none;">
        + Create Contract
      </a>
    </header>

    <!-- Filters -->
    <form @submit="onSearch" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
      <input
        name="q"
        :value="filters?.q || ''"
        placeholder="Search recipient name or email..."
        style="padding:8px;border:1px solid #ddd;border-radius:8px;flex:1;min-width:240px;"
      />
      <select
        name="status"
        :value="filters?.status || ''"
        style="padding:8px;border:1px solid #ddd;border-radius:8px;"
      >
        <option value="">All statuses</option>
        <option value="draft">Draft</option>
        <option value="sent">Sent</option>
        <option value="pending">Pending</option>
        <option value="signed">Signed</option>
      </select>
      <button type="submit" style="padding:8px 12px;border:1px solid #111;border-radius:8px;background:#111;color:#fff;">
        Apply
      </button>
    </form>

    <!-- Table -->
    <div style="overflow:auto;border:1px solid #eee;border-radius:10px;">
      <table cellpadding="10" cellspacing="0" width="100%">
        <thead style="background:#fafafa;border-bottom:1px solid #eee;">
          <tr>
            <th align="left">Recipient</th>
            <th align="left">Email</th>
            <th align="left">Status</th>
            <th align="left">Sent</th>
            <th align="left">Signed</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="!contracts?.data?.length">
            <td colspan="5">No contracts yet.</td>
          </tr>
          <tr v-for="c in contracts.data" :key="c.contract_id" style="border-top:1px solid #f3f4f6;">
            <td>{{ c.recipient_name }}</td>
            <td>{{ c.recipient_email }}</td>
            <td>
              <span :style="{
                padding:'2px 8px',
                borderRadius:'999px',
                border:'1px solid #e5e7eb',
                backgroundColor: c.status === 'signed' ? '#dcfce7'
                               : c.status === 'sent' ? '#fef9c3'
                               : c.status === 'pending' ? '#e5e7eb'
                               : '#f3f4f6'
              }">
                {{ c.status || '—' }}
              </span>
            </td>
            <td>{{ c.sent_date ? new Date(c.sent_date).toLocaleString() : '—' }}</td>
            <td>{{ c.signed_date ? new Date(c.signed_date).toLocaleString() : '—' }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="contracts?.links?.length" style="margin-top:12px; display:flex; gap:6px; flex-wrap:wrap;">
      <button
        v-for="link in contracts.links"
        :key="(link.url || '') + link.label"
        :disabled="!link.url"
        @click="link.url && router.visit(link.url, { preserveState: true })"
        v-html="link.label"
        :style="{
          padding:'6px 10px',
          borderRadius:'6px',
          border:'1px solid #ddd',
          background: link.active ? '#111' : '#fff',
          color: link.active ? '#fff' : '#111',
          cursor: link.url ? 'pointer' : 'not-allowed'
        }"
      />
    </div>
  </section>
</template>