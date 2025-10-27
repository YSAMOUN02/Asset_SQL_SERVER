@extends('backend.master')
@section('content')
@section('header')
    Hierachical Organization & User Management
@endsection

@section('style')
    <span class=" mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl">
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">
            Hierachical Organization & User Management
        </span>
    </span>
@endsection

<div class="grid grid-cols-2 gap-4 bg-gray-100 dark:bg-gray-900 p-4 rounded-xl shadow-lg overflow-auto max-h-[90vh]">

    {{-- Organization Hierarchy --}}
    <div class="overflow-auto max-h-[90vh]">
        <h3 class="text-xl font-semibold text-gray-900 bg-white dark:bg-black p-2 dark:text-white mb-4 sticky top-0">
            Organization Hierarchy</h3>

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

                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <button class="text-green-600 hover:text-green-800 text-sm font-medium"
                                onclick="event.stopPropagation(); openAddModal('company','{{ $comp->id }}','{{ $comp->name }}')">
                                + Add
                            </button>
                            @if ($comp->canDelete)
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium"
                                    onclick="event.stopPropagation(); openDeleteModal('company','{{ $comp->id }}','{{ $comp->name }}', this)">
                                    Delete
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="children-container ml-4 mt-2 space-y-2 hidden"></div>
                </div>
            @endforeach

            <!-- New section outside foreach -->
            <div class="hierarchy-node mt-4">
                <div
                    class="node-row flex items-center justify-between bg-white dark:bg-gray-800 shadow rounded p-2 cursor-pointer">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">+ Add New Company</p>
                    </div>

                    <div class="flex space-x-2 rtl:space-x-reverse">
                        <button class="text-green-600 hover:text-green-800 text-sm font-medium"
                            onclick="event.stopPropagation(); openAddModal('company', 0, 'New Company')">
                            + Add
                        </button>
                    </div>
                </div>
                <div class="children-container ml-4 mt-2 space-y-2 hidden"></div>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div>
        <div class="overflow-auto mb-4  max-h-[35vh] min-h-[35vh] ">
            <div class="flex justify-between items-center mb-2 ">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">Entire Directory</span>
                <div class="flex space-x-2">
                    <select id="searchType" class="border rounded px-2 py-1 dark:bg-gray-700 dark:text-white bg-white">

                        <option value="name">Full Name</option>
                        <option value="id_card">ID Card</option>
                        <option value="email">Email</option>
                        <option value="role">Role</option>
                        <option value="position">Position</option>
                        <option value="phone">Phone</option>
                        <option value="company">Company</option>
                        <option value="department">Department</option>
                        <option value="division">Division</option>
                        <option value="section">Section</option>
                        <option value="group">Group</option>
                    </select>
                    <input type="text" id="searchInput" list="searchOptions" placeholder="Search..."
                        class="border rounded px-2 py-1 w-full dark:bg-gray-700 dark:text-white bg-white">
                    <datalist id="searchOptions"></datalist>
                </div>
            </div>

            <table id="searchUsersTable" class="min-w-full border-collapse table-auto">
                <thead class="bg-whitedark:bg-gray-900 ">
                    <tr   tabindex="0">
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">#</th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Name</th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Email</th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Current Location</th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Action</th>
                    </tr>
                </thead>
                <tbody id="searchUsersBody"
                    class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-nowrap">
                    <tr   tabindex="0">
                        <td colspan="5" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users
                            found</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="overflow-auto min-h-[45vh] max-h-[45vh]">
            <div class="flex justify-between items-center ">
                <span class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Selected Directory</span>


                <div>
                    <input type="text" id="searchInput2" list="list_user" placeholder="Search..."
                        oninput="search_onlist(this)"
                        class="border rounded px-2 py-1 w-full dark:bg-gray-700 dark:text-white bg-white">
                    <datalist id="list_user"></datalist>
                </div>

            </div>
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
                        <tr   tabindex="0">
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white  ">#</th>
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Name</th>
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Email</th>
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Current Location</th>
                            <th id="actionHeader"
                                class="px-4 py-2 text-left text-gray-900 dark:text-white sticky right-0 bg-gray-200 dark:bg-gray-800">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody id="users"
                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-nowrap">
                        <tr   tabindex="0">
                            <td colspan="5" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users
                                selected</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div id="addModal" class="modal_z_hight_index fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">
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
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>
{{-- Update Modal --}}
<div id="updateModal"
    class="modal_z_hight_index fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
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
<!-- Delete Modal -->
<div id="deleteModal"
    class="modal_z_hight_index fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96 shadow-lg">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Confirm Delete</h2>
        <p id="deleteMessage" class="mb-4 text-gray-700 dark:text-gray-300">Are you sure you want to delete this item?
        </p>
        <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeDeleteModal()"
                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded">Cancel</button>
            <button id="confirmDeleteBtn" type="button"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
        </div>
    </div>
</div>
{{-- Delete User Modal --}}
<div id="deleteUserModal"
    class="modal_z_hight_index fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96 shadow-lg">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Delete User</h2>
        <p id="deleteUserText" class="mb-4 text-gray-700 dark:text-gray-300"></p>
        <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeDeleteUserModal()"
                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded">Cancel</button>
            <button type="button" id="confirmDeleteUserBtn"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
        </div>
    </div>
</div>
<script>
    let users_for_search = [];

    function search_onlist(e) {
        const query = e.value.trim().toLowerCase();
        const list = document.getElementById("list_user");
        list.innerHTML = "";

        // Filter users by full name (fname + lname)
        const filtered = users_for_search.filter(u => {
            const fullName = `${u.name}`.toLowerCase();
            return fullName.includes(query);
        });

        // Update datalist
        filtered.forEach(u => {
            const option = document.createElement("option");
            option.value = `${u.name}`;
            option.dataset.id = u.id;
            list.appendChild(option);
        });

        // Rewrite table
        const usersTbody = document.getElementById('users');
        let userHtml = '';

        if (filtered.length > 0) {
            filtered.forEach((u, idx) => {
                userHtml += `
                <tr   tabindex="0" draggable="true" data-user-id="${u.id}" class="hover:bg-gray-50 dark:hover:bg-gray-700 text-sm">
                    <td class="px-1 py-0">${idx + 1}</td>
                    <td class="px-1 py-0 text-gray-900 dark:text-white">${escapeHtml(u.name)}</td>
                    <td class="px-1 py-0 text-gray-900 dark:text-white">${escapeHtml(u.email || '-')}</td>
                    <td class="px-1 py-0 text-gray-900 dark:text-white">${escapeHtml(u.location_path || '-')}</td>
                    <td class="px-1 py-0 sticky right-0 bg-white dark:bg-gray-800">
                        <a href="/admin/user/update/id=${u.id}" target="_blank" rel="noopener noreferrer">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-1 py-1 rounded shadow">
                                <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                            </button>
                        </a>
                        <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-1 py-1 rounded shadow"
                            onclick="openDeleteUserModal(${u.id}, '${escapeHtml(u.fname)} ${escapeHtml(u.lname)}')">
                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                        </button>
                    </td>
                </tr>`;
            });
        } else {
            userHtml = `
            <tr   tabindex="0">
                <td colspan="5" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">
                    No users found
                </td>
            </tr>`;
        }

        usersTbody.innerHTML = userHtml;
    }

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

        // ===== Handle collapse first (before highlight) =====
        if (!reload && !childrenContainer.classList.contains('hidden')) {
            childrenContainer.classList.add('hidden');
            childrenContainer.innerHTML = '';
            document.getElementById('users').innerHTML =
                `<tr   tabindex="0"><td colspan="5" class="text-center text-gray-500 dark:text-gray-400 px-4 py-2">No users selected</td></tr>`;
            updateBreadcrumb([]);
            element.classList.remove('active');
            return;
        }

        // ===== Highlight / focus selected node + its parents =====
        document.querySelectorAll('.node-row.active').forEach(node => node.classList.remove('active'));

        let currentNode = element;
        while (currentNode) {
            if (currentNode.classList.contains('node-row')) {
                currentNode.classList.add('active');
            }
            currentNode = currentNode.closest('.hierarchy-node')
                ?.parentElement?.closest('.hierarchy-node')
                ?.querySelector('.node-row');
        }

        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        try {
            // ===== Fetch children =====
            const res = await showLoader(async () => {
                const response = await fetch(`/hierarchy/${type}/${id}/children`, {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Cache-Control": "no-cache",
                        Pragma: "no-cache",
                    },
                });
                return await response.json();
            });

            const children = res;
            childrenContainer.innerHTML = '';

            // 🟡 If no children, auto-collapse and stop here
            if (!Array.isArray(children) || children.length === 0) {
                childrenContainer.classList.add('hidden');
                element.classList.remove('active');
                updateBreadcrumb(getNodePath(element));
                // Still fetch users, but no subnodes
                const users = await fetchUsersForNode(type, id);
                renderUsers(users);
                return;
            }


            // ===== Build child nodes =====
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

                    const canDelete = child.total_users === 0 && !child.hasChildren;

                    row.innerHTML = `
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            ${child.code} - ${child.name}
                        </p>
                    </div>
                    <div class="flex space-x-2 rtl:space-x-reverse">
                        <button class="text-green-600 hover:text-green-800 text-sm font-medium"
                            onclick="event.stopPropagation(); openAddModal('${child.type}','${child.id}','${child.name}','${child.code}')">
                            + Add
                        </button>
                        ${canDelete
                            ? `<button class="text-red-600 hover:text-red-800 text-sm font-medium"
                                  onclick="event.stopPropagation(); openDeleteModal('${child.type}','${child.id}','${child.name}', this)">
                                  Delete
                               </button>`
                            : ''}
                    </div>`;

                    row.addEventListener('click', function() {
                        toggleChildren(this);
                    });

                    row.addEventListener('dblclick', function(e) {
                        if (!e.target.closest('button')) {
                            e.stopPropagation();
                            openUpdateModal(row.dataset.type, row.dataset.id, row.dataset.name, row
                                .dataset.code);
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
                // Auto-collapse if all invalid
                childrenContainer.classList.add('hidden');
                element.classList.remove('active');
            } else {
                childrenContainer.classList.remove('hidden');
            }

            updateBreadcrumb(getNodePath(element));

            // ===== Fetch and render users =====
            const users = await fetchUsersForNode(type, id);
            renderUsers(users);

        } catch (error) {
            alert(error);
        }
    }

    /* ===== Helpers for users ===== */
    async function fetchUsersForNode(type, id) {
        const response = await fetch(`/hierarchy/${type}/${id}/users`, {
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
                "Cache-Control": "no-cache",
                Pragma: "no-cache",
            },
        });
        return await response.json();
    }


    function renderUsers(users) {
        const usersTbody = document.getElementById('users');
        let html = '';
        users_for_search = users;

        if (Array.isArray(users) && users.length) {
            users.forEach((u, idx) => {
                html += `
            <tr   tabindex="0" draggable="true" data-user-id="${u.id}" class="hover:bg-gray-50 dark:hover:bg-gray-700 text-sm">
                <td class="px-1 py-0">${idx + 1}</td>
                <td class="px-1 py-0 text-gray-900 dark:text-white">${escapeHtml(u.name)}</td>
                <td class="px-1 py-0 text-gray-900 dark:text-white">${escapeHtml(u.email || '-')}</td>
                <td class="px-1 py-0 text-gray-900 dark:text-white">${escapeHtml(u.location_path || '-')}</td>
                <td class="px-1 py-0 sticky right-0 bg-white dark:bg-gray-800">
                    <a href="/admin/user/update/id=${u.id}" target="_blank" rel="noopener noreferrer">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-1 py-1 rounded shadow">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </a>
                    <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-1 py-1 rounded shadow"
                        onclick="openDeleteUserModal(${u.id}, '${escapeHtml(u.name)}')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>`;
            });
        } else {
            html =
                `<tr   tabindex="0"><td colspan="5" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users found</td></tr>`;
        }

        usersTbody.innerHTML = html;
    }



    /* ===== Drag & Drop ===== */
    function enableDrop(row) {
        // Highlight when dragging over
        row.addEventListener('dragover', (e) => {
            e.preventDefault();
            row.classList.add('ring-2', 'ring-blue-400');
        });

        row.addEventListener('dragleave', () => {
            row.classList.remove('ring-2', 'ring-blue-400');
        });

        // Handle drop
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
                    showSuccessToast('User moved successfully');

                    // ✅ Remove user row from current table only
                    const draggedRow = document.querySelector(`tr[data-user-id="${userId}"]`);
                    if (draggedRow) draggedRow.remove();

                    // ✅ If table now empty, show placeholder
                    const usersTbody = document.getElementById('users');
                    const hasUsers = usersTbody.querySelector('tr');
                    if (!hasUsers) {
                        usersTbody.innerHTML = `
                        <tr   tabindex="0">
                            <td colspan="5" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">
                                No users found
                            </td>
                        </tr>`;
                    }

                } else {
                    showErrorToast(data.message || 'Move failed');
                }
            } catch (err) {
                console.error(err);
                showErrorToast('Move failed');
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
            `<tr   tabindex="0"><td colspan="5" class="px-1 py-1 text-gray-500 dark:text-gray-400 text-center">No users selected</td></tr>`;
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
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addModal').classList.remove('flex');
    }

    function openAddModal(type, parentId = null, name = '') {
        document.getElementById('parentType').value = type;
        document.getElementById('parentId').value = parentId;
        document.getElementById('childName').value = '';
        document.getElementById('childCode').value = '';
        document.getElementById('modalTitle').innerText = `Add under ${name}`;
        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('addModal').classList.add('flex');
    }

    document.getElementById('addForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const type = document.getElementById('parentType').value;
        const parentId = document.getElementById('parentId').value;
        const name = document.getElementById('childName').value.trim();
        const code = document.getElementById('childCode').value.trim();

        if (!name || !code) return showErrorToast('Enter both code and name');

        let url = '';
        let body = {
            name,
            code
        };

        if (type === 'company' && (!parentId || parentId == 0)) {
            url = `/hierarchy/add-company`; // new endpoint
        } else {
            url = `/hierarchy/${type}/${parentId}/add-child`;
        }

        try {

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(body)
            });





            const data = await res.json();

            if (data.success) {
                closeAddModal();
                showSuccessToast('Added successfully');

                // Insert into DOM
                if (type === 'company' && (!parentId || parentId == 0)) {
                    const container = document.getElementById('hierarchy-container');
                    const addNewNode = container.querySelector('.hierarchy-node.mt-4');

                    const newNode = document.createElement('div');
                    newNode.className = 'hierarchy-node';
                    newNode.innerHTML = `
                    <div class="node-row flex items-center justify-between bg-white dark:bg-gray-800 shadow rounded p-2 cursor-pointer"
                        data-id="${data.node.id}" data-type="company" data-name="${data.node.name}"
                        onclick="toggleChildren(this)">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">${data.node.name}</p>
                        </div>
                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <button class="text-green-600 hover:text-green-800 text-sm font-medium"
                                onclick="event.stopPropagation(); openAddModal('company','${data.node.id}','${data.node.name}')">+ Add</button>
                        </div>
                    </div>
                    <div class="children-container ml-4 mt-2 space-y-2 hidden"></div>
                `;
                    container.insertBefore(newNode, addNewNode);
                } else {
                    // existing behavior for child nodes
                    const row = document.querySelector(
                        `.node-row[data-id="${parentId}"][data-type="${type}"]`);
                    if (row) toggleChildren(row);
                }
            } else {
                showErrorToast(data.message || 'Failed to add');
            }
        } catch (err) {
            console.error(err);
            closeAddModal();
            showErrorToast('Add failed');
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

        if (!name || !code) {
            showErrorToast('Enter both code and name');
            return;
        }

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
                closeUpdateModal();

                const row = document.querySelector(`.node-row[data-id="${id}"][data-type="${type}"]`);
                if (row && data.node) {
                    const label = row.querySelector('p');
                    if (label) {
                        label.innerText = `${data.node.code} - ${data.node.name}`;
                    }
                }

                showSuccessToast('Updated successfully');
            } else {
                showErrorToast(data.message || 'Update failed');
            }
        } catch (err) {
            console.error(err);
            showErrorToast('Update failed. Please try again.');
        }
    });



    let deleteTarget = null; // store node info temporarily

    function openDeleteModal(type, id, name, rowElement) {
        deleteTarget = {
            type,
            id,
            rowElement
        };

        const message = `Are you sure you want to delete "${name}"?`;
        document.getElementById('deleteMessage').innerText = message;

        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteTarget = null;
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
        if (!deleteTarget) return;

        try {
            // Send delete request to backend
            const res = await fetch(`/hierarchy/${deleteTarget.type}/${deleteTarget.id}/delete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // Parse JSON response
            const data = await res.json();
            console.log('Delete response:', data); // Debug

            if (data.success === true) {
                if (deleteTarget.rowElement) {
                    deleteTarget.rowElement.closest('.hierarchy-node').remove();
                }
                closeDeleteModal();
                showSuccessToast(data.message || 'Deleted successfully');
            } else {
                closeDeleteModal();
                showErrorToast(data.message || 'Cannot delete node with users');
            }

        } catch (err) {
            console.error('Delete error:', err);

            // Close modal
            closeDeleteModal();

            // Show red error toast
            showErrorToast('Delete failed. Please try again.');
        }
    });





    function openDeleteUserModal(userId, userName) {
        const modal = document.getElementById('deleteUserModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.getElementById('deleteUserText').innerText = `Are you sure you want to delete "${userName}"?`;

        const confirmBtn = document.getElementById('confirmDeleteUserBtn');
        confirmBtn.onclick = async () => {
            try {
                const res = await fetch(`/admin/user/delete/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    showSuccessToast(data.message || 'User deleted successfully');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');

                    // Remove user row from table
                    const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                    if (row) row.remove();
                } else {
                    showErrorToast(data.message || 'Delete failed');
                }
            } catch (err) {
                console.error(err);
                showErrorToast('Delete failed');
            }
        };
    }

    function closeDeleteUserModal() {
        const modal = document.getElementById('deleteUserModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    const searchType = document.getElementById('searchType');
    const searchInput = document.getElementById('searchInput');
    const datalist = document.getElementById('searchOptions');

    searchType.addEventListener('change', updateDatalist);
    searchInput.addEventListener('input', updateDatalist);

    async function updateDatalist() {
        const type = searchType.value;
        const query = searchInput.value;

        try {
            const res = await fetch(`/search-datalist?type=${type}&query=${encodeURIComponent(query)}`);
            const data = await res.json();

            datalist.innerHTML = '';

            console.log('Datalist options:', data); // Debug
            if (Array.isArray(data) && data.length) {
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item; // for users, use fname+lname
                    datalist.appendChild(option);
                });
            }
        } catch (err) {
            console.error('Failed to fetch datalist options:', err);
        }
    }



    async function searchUsers() {
        const type = document.getElementById('searchType').value;
        const query = document.getElementById('searchInput').value.trim();
        // get the tbody (unique id)
        const usersTbody = document.getElementById('searchUsersBody');
        if (!query) {
            usersTbody.innerHTML =
                `<tr   tabindex="0"><td colspan="5" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users found</td></tr>`;
            return;
        }

        try {
            const res = await fetch(`/search-users?type=${type}&query=${encodeURIComponent(query)}`);
            const users = await res.json();

            usersTbody.innerHTML = '';

            if (Array.isArray(users) && users.length) {
                // clear placeholder
                usersTbody.innerHTML = '';

                users.forEach((u, idx) => {

                    const tr = document.createElement('tr');

                    // table-appropriate classes (no flex)
                    tr.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
                    tr.setAttribute('draggable', 'true');
                    tr.dataset.userId = u.id;

                    tr.innerHTML = `
            <td class="px-1 py-0">${idx + 1}</td>
            <td class="px-1 py-0 text-gray-900 dark:text-white text-sm">${escapeHtml(u.fname + ' ' + u.lname)}</td>
            <td class="px-1 py-0 text-gray-900 dark:text-white text-sm">${escapeHtml(u.email || '-')}</td>
            <td class="px-1 py-0 text-gray-900 dark:text-white text-sm">${escapeHtml(u.location_path || '-')}</td>

            <td class="px-1 py-0 sticky right-0 bg-white dark:bg-gray-800">
                <a href="/admin/user/update/id=${u.id}" target="_blank" rel="noopener noreferrer">
                  <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-1 py-1 rounded shadow"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button>
                </a>
                <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-1 py-1 rounded shadow"
                    onclick="openDeleteUserModal(${u.id}, '${escapeHtml(u.fname + ' ' + u.lname)}')">
                    <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                </button>
            </td>
        `;

                    // attach dragstart directly on the new row (so it always works)
                    tr.addEventListener('dragstart', function(e) {
                        e.dataTransfer.setData('userId', tr.dataset.userId);
                        e.dataTransfer.effectAllowed = 'move';
                    });

                    usersTbody.appendChild(tr);
                });
            } else {
                usersTbody.innerHTML =
                    `<tr   tabindex="0"><td colspan="5" class="px-4 py-2 text-gray-500 dark:text-gray-400 text-center">No users found</td></tr>`;
            }
        } catch (err) {
            console.error('Search failed:', err);
            usersTbody.innerHTML =
                `<tr   tabindex="0"><td colspan="5" class="px-4 py-2 text-red-500 text-center">Search failed</td></tr>`;
        }
    }

    // Trigger search on input
    document.getElementById('searchInput').addEventListener('input', searchUsers);
    document.getElementById('searchType').addEventListener('change', searchUsers);
</script>
@endsection
