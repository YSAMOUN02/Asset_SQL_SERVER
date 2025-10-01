@extends('backend.master')
@section('content')
@section('header')
    Hierachical Organization & User Management
@endsection

@section('style')
    <span class="ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl">
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">
         Hierachical Organization & User Management
        </span>
    </span>
@endsection

<div class="grid grid-cols-2 gap-4 bg-gray-100 dark:bg-gray-900 p-4 rounded-xl shadow-lg overflow-auto max-h-[90vh]">

    {{-- Organization Hierarchy --}}
    <div class="overflow-auto">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Organization Hierarchy</h3>

        <div id="hierarchy-container" class="space-y-2">
            @foreach ($company as $comp)
                <div class="hierarchy-node">
                    <div class="node-row flex items-center justify-between bg-white dark:bg-gray-800 shadow rounded p-2 cursor-pointer"
                        data-id="{{ $comp->id }}" data-type="company" data-name="{{ $comp->name }}"
                        onclick="toggleChildren(this)">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $comp->name }}
                            </p>
                        </div>
                        <button class="text-green-600 hover:text-green-800 text-sm font-medium"
                            onclick="event.stopPropagation(); openAddModal('company','{{ $comp->id }}','{{ $comp->name }}')">
                            + Add
                        </button>
                    </div>
                    <div class="children-container ml-4 mt-2 space-y-2 hidden"></div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Users Table --}}
    <div class="overflow-auto">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Users</h3>

        {{-- Breadcrumb --}}
        <nav id="breadcrumb" class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <a href="#" onclick="resetHierarchy()"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Home
                    </a>
                </li>
            </ol>
        </nav>

        <div class="overflow-auto max-h-[80vh]">
            <table id="table_user" class="min-w-full border-collapse table-auto">
                <thead class="bg-gray-200 dark:bg-gray-800 sticky top-0">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">#</th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Name</th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Email</th>
                        <th  id="actionHeader"
                            class="px-4 py-2 text-left text-gray-900 dark:text-white sticky right-0 bg-gray-200 dark:bg-gray-800">
                            Action</th>
                    </tr>
                </thead>
                <tbody id="users" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users
                            selected</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96 shadow-lg">
        <h2 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Add</h2>
        <form id="addForm">
            <input type="hidden" id="parentType" name="parentType">
            <input type="hidden" id="parentId" name="parentId">

            <div class="mb-3">
                <label for="childCode" class="block text-sm text-gray-700 dark:text-gray-300">Code</label>
                <input id="childCode" name="childCode" type="text"
                    class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
            </div>

            <div class="mb-3">
                <label for="childName" class="block text-sm text-gray-700 dark:text-gray-300">Name</label>
                <input id="childName" name="childName" type="text"
                    class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeAddModal()"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>
{{-- Update Modal --}}
<div id="updateModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96 shadow-lg">
        <h2 id="updateModalTitle" class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Update</h2>
        <form id="updateForm">
            <input type="hidden" id="updateType" name="updateType">
            <input type="hidden" id="updateId" name="updateId">

            <div class="mb-3">
                <label for="updateCode" class="block text-sm text-gray-700 dark:text-gray-300">Code</label>
                <input id="updateCode" name="updateCode" type="text"
                    class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
            </div>

            <div class="mb-3">
                <label for="updateName" class="block text-sm text-gray-700 dark:text-gray-300">Name</label>
                <input id="updateName" name="updateName" type="text"
                    class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeUpdateModal()"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    /* ===== Helpers ===== */
    function escapeHtml(str) {
        return String(str ?? '').replace(/[&<>"'`=\/]/g, s => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '/': '&#x2F;',
            '`': '&#x60;',
            '=': '&#x3D;'
        })[s]);
    }

    /* ===== Toggle children ===== */
    async function toggleChildren(element, reload = false) {
        const nodeWrap = element.closest('.hierarchy-node');
        if (!nodeWrap) return;
        const childrenContainer = nodeWrap.querySelector('.children-container');
        if (!childrenContainer) return;

        const type = element.dataset.type;
        const id = element.dataset.id;

        // Collapse if already open and not forced reload
        if (!reload && !childrenContainer.classList.contains('hidden')) {
            childrenContainer.classList.add('hidden');
            childrenContainer.innerHTML = '';
            document.getElementById('users').innerHTML =
                `<tr><td colspan="4" class="text-center text-gray-500 dark:text-gray-400 px-4 py-2">No users selected</td></tr>`;
            updateBreadcrumb([]);
            return;
        }

        try {
            // Fetch children
            const res = await fetch(`/hierarchy/${type}/${id}/children`);
            const children = await res.json();

            childrenContainer.innerHTML = '';

            let canDeleteParent = false; // check if parent can be deleted
            if (Array.isArray(children) && children.length > 0) {
                let hasValidChild = false;

                children.forEach(child => {
                    if (child.code && child.name) {
                        hasValidChild = true;

                        const childWrap = document.createElement('div');
                        childWrap.className = 'hierarchy-node';

                        const row = document.createElement('div');
                        row.className =
                            'node-row flex items-center justify-between bg-white dark:bg-gray-700 shadow rounded p-2 ml-4 cursor-pointer';
                        row.dataset.id = child.id;
                        row.dataset.type = child.type;
                        row.dataset.name = child.name || '';
                        row.dataset.code = child.code || '';

                        enableDrop(row);

                        // Determine if child can be deleted (no child & no users)
                        const canDelete = child.total_users === 0 && !child.hasChildren;

                        row.innerHTML = `
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                ${child.code} - ${child.name}
                            </p>
                        </div>
                        ${
                            canDelete
                            ? `<button class="text-red-600 hover:text-red-800 text-sm font-medium ml-3"
                                    onclick="event.stopPropagation(); deleteNode('${child.type}', ${child.id}, this)">
                                    Delete
                               </button>`
                            : `<button class="text-green-600 hover:text-green-800 text-sm font-medium ml-3"
                                    onclick="event.stopPropagation(); openAddModal('${child.type}','${child.id}','${child.name}','${child.code}')">
                                    + Add
                               </button>`
                        }
                    `;

                        // Single click to toggle children
                        row.addEventListener('click', function() {
                            toggleChildren(this);
                        });

                        // Double-click to update
                        row.addEventListener('dblclick', function(e) {
                            // Only trigger update if double-click is not on a button
                            if (!e.target.closest('button')) {
                                e.stopPropagation();
                                openUpdateModal(
                                    row.dataset.type,
                                    row.dataset.id,
                                    row.dataset.name,
                                    row.dataset.code
                                );
                            }
                        });

                        const childChildrenContainer = document.createElement('div');
                        childChildrenContainer.className = 'children-container ml-4 mt-2 space-y-2 hidden';

                        childWrap.appendChild(row);
                        childWrap.appendChild(childChildrenContainer);
                        childrenContainer.appendChild(childWrap);
                    }
                });

                if (!hasValidChild) {
                    childrenContainer.innerHTML =
                        `<div class="flex items-center justify-between bg-white dark:bg-gray-700 shadow rounded p-2 ml-4 cursor-pointer text-gray-500 italic">No data</div>`;
                }
            } else {

            }

            childrenContainer.classList.remove('hidden');
            updateBreadcrumb(getNodePath(element));

            // Fetch users
            const userRes = await fetch(`/hierarchy/${type}/${id}/users`);
            const users = await userRes.json();
            const usersTbody = document.getElementById('users');
            let userHtml = '';

            if (Array.isArray(users) && users.length) {
                users.forEach((u, idx) => {
                    userHtml += `
                    <tr draggable="true" data-user-id="${u.id}" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-2">${idx + 1}</td>
                        <td class="px-4 py-2 text-gray-900 dark:text-white">${escapeHtml(u.name)}</td>
                        <td class="px-4 py-2 text-gray-900 dark:text-white">${escapeHtml(u.email || '-')}</td>
                        <td class="px-4 py-2 sticky right-0 bg-white dark:bg-gray-800">
                            <a href="/admin/user/update/id=${u.id}">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded shadow">Edit</button>
                            </a>
                        </td>
                    </tr>`;
                });
            } else {
                userHtml =
                    `<tr><td colspan="4" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users found</td></tr>`;
            }
            usersTbody.innerHTML = userHtml;

        } catch (err) {
            console.error('Error fetching hierarchy/children/users:', err);
        }
    }


    /* ===== Drag & Drop ===== */
    function enableDrop(row) {
        row.addEventListener('dragover', (e) => {
            e.preventDefault();
            row.classList.add('ring-2', 'ring-blue-400');
        });
        row.addEventListener('dragleave', () => {
            row.classList.remove('ring-2', 'ring-blue-400');
        });
        row.addEventListener('drop', async (e) => {
            e.preventDefault();
            row.classList.remove('ring-2', 'ring-blue-400');

            const userId = e.dataTransfer.getData('userId');
            if (!userId) return;

            const targetType = row.dataset.type;
            const targetId = row.dataset.id;

            try {
                const res = await fetch(`/hierarchy/move-user`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        userId,
                        targetType,
                        targetId
                    })
                });

                const data = await res.json();
                if (data.success) {
                    alert('User moved successfully');
                    location.reload(); // simplest way to refresh tree & table
                } else {
                    alert(data.message || 'Move failed');
                }

            } catch (err) {
                console.error(err);
                alert('Move failed');
            }
        });

    }

    document.addEventListener('dragstart', function(e) {
        if (e.target.matches('tr[draggable="true"]')) {
            e.dataTransfer.setData('userId', e.target.dataset.userId);
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    /* ===== Breadcrumb ===== */
    function getNodePath(nodeRowElement) {
        const path = [];
        let current = nodeRowElement;
        while (current) {
            path.unshift({
                id: current.dataset.id,
                type: current.dataset.type,
                name: current.dataset.name
            });
            current = current.closest('.hierarchy-node')?.parentElement.closest('.hierarchy-node')?.querySelector(
                '.node-row');
        }
        return path;
    }

    function updateBreadcrumb(path) {
        const breadcrumb = document.querySelector('#breadcrumb ol');
        breadcrumb.innerHTML = `
        <li>
            <a href="#" onclick="resetHierarchy()"
               class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                Home
            </a>
        </li>`;
        path.forEach((node, i) => {
            breadcrumb.innerHTML += `
            <li>
                <span class="mx-1">/</span>
                <a href="#" onclick="toggleBreadcrumbNode('${node.id}','${node.type}')"
                   class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                   ${escapeHtml(node.name)}
                </a>
            </li>`;
        });
    }

    function resetHierarchy() {
        document.getElementById('users').innerHTML =
            `<tr><td colspan="4" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users selected</td></tr>`;
        document.querySelectorAll('.children-container').forEach(cc => {
            cc.classList.add('hidden');
            cc.innerHTML = '';
        });
        updateBreadcrumb([]);
    }

    function toggleBreadcrumbNode(id, type) {
        const row = document.querySelector(`.node-row[data-id="${id}"][data-type="${type}"]`);
        if (row) toggleChildren(row);
    }
    /* ===== Add Modal ===== */
    function openAddModal(type, id, name = '', code = '') {
        document.getElementById('parentType').value = type;
        document.getElementById('parentId').value = id;

        // Only prefill if values are passed; for "Add New", leave empty
        document.getElementById('childName').value = '';
        document.getElementById('childCode').value = '';

        document.getElementById('modalTitle').innerText = "Add under " + (name || '');
        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('addModal').classList.add('flex');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addModal').classList.remove('flex');
    }
    document.getElementById('addForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const type = document.getElementById('parentType').value;
        const parentId = document.getElementById('parentId').value;
        const name = document.getElementById('childName').value.trim();
        const code = document.getElementById('childCode').value.trim();

        if (!name || !code) return alert('Enter both code and name');

        try {
            const res = await fetch(`/hierarchy/${type}/${parentId}/add-child`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name,
                    code
                })
            });

            const data = await res.json();

            if (data.success) {
                // refresh tree for real
                const row = document.querySelector(`.node-row[data-id="${parentId}"][data-type="${type}"]`);
                if (row) {
                    const wrap = row.closest('.hierarchy-node');
                    const cc = wrap.querySelector('.children-container');
                    if (cc) {
                        cc.classList.add('hidden');
                        cc.innerHTML = '';
                    }
                    toggleChildren(row); // reload children from backend
                }
                closeAddModal();
            } else {
                alert(data.message || 'Failed to add');
            }
        } catch (err) {
            console.error(err);
            alert('Add failed');
        }
    });

    function openUpdateModal(type, id, name = '', code = '') {
        const typeInput = document.getElementById('updateType');
        const idInput = document.getElementById('updateId');
        const nameInput = document.getElementById('updateName');
        const codeInput = document.getElementById('updateCode');

        if (!typeInput || !idInput || !nameInput || !codeInput) {
            console.error('Update modal elements not found in DOM');
            return;
        }

        typeInput.value = type;
        idInput.value = id;
        nameInput.value = name;
        codeInput.value = code;

        document.getElementById('updateModal').classList.remove('hidden');
        document.getElementById('updateModal').classList.add('flex');
    }

    function closeUpdateModal() {
        document.getElementById('updateModal').classList.add('hidden');
        document.getElementById('updateModal').classList.remove('flex');
    }
    document.getElementById('updateForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const type = document.getElementById('updateType').value;
        const id = document.getElementById('updateId').value;
        const name = document.getElementById('updateName').value.trim();
        const code = document.getElementById('updateCode').value.trim();

        if (!name || !code) return alert('Enter both code and name');

        try {
            const res = await fetch(`/hierarchy/${type}/${id}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name,
                    code
                })
            });

            const data = await res.json();
            if (data.success) {
                alert('Updated successfully');
                closeUpdateModal();
                toggleChildren(document.querySelector(`.node-row[data-id="${id}"][data-type="${type}"]`),
                    true);
            } else {
                alert(data.message || 'Update failed');
            }
        } catch (err) {
            console.error(err);
            alert('Update failed');
        }
    });
</script>
@endsection
