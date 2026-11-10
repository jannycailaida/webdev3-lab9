<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBDEV3 · Lab Exercise 9 — RESTful API & Sanctum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-sans">
    <!-- Header -->
    <header class="border-b border-slate-800 bg-slate-900/70 backdrop-blur sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-indigo-400">
                    <span>WEBDEV3 · Week 11 Lecture</span>
                    <span>•</span>
                    <span>Lab Exercise 9</span>
                </div>
                <h1 class="text-xl font-bold text-white mt-0.5">RESTful API Development — Live API Explorer</h1>
            </div>

            <!-- Token Status & Postman Export -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="/download-postman-collection" class="bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 border border-indigo-500/30 text-xs font-semibold px-3.5 py-2 rounded-lg transition flex items-center gap-1.5">
                    <span>⬇ Download Postman .json</span>
                </a>
                <div class="flex items-center gap-3 bg-slate-950 border border-slate-800 rounded-lg px-4 py-2">
                    <span class="text-xs font-medium text-slate-400">Bearer Token:</span>
                    <code id="tokenDisplay" class="text-xs font-mono text-amber-400 max-w-xs truncate">None (Not Logged In)</code>
                    <button onclick="clearToken()" class="text-xs text-rose-400 hover:text-rose-300 underline ml-2">Clear</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Endpoints & Actions -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Step 1: Sanctum Auth -->
            <section class="bg-slate-900 border border-slate-800 rounded-xl p-5 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-indigo-400">1. Sanctum Token Authentication</h2>
                    <span class="text-xs bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 px-2 py-0.5 rounded">Slide 7</span>
                </div>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block text-slate-400 mb-1">Email</label>
                        <input id="loginEmail" type="email" value="juan@example.com" class="w-full bg-slate-950 border border-slate-800 rounded px-3 py-2 text-slate-100 font-mono">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Password</label>
                        <input id="loginPassword" type="text" value="password123" class="w-full bg-slate-950 border border-slate-800 rounded px-3 py-2 text-slate-100 font-mono">
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button onclick="loginApi()" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold py-2.5 px-4 rounded-lg transition">
                        POST /api/login (Get Token)
                    </button>
                    <button onclick="logoutApi()" class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold py-2.5 px-4 rounded-lg transition">
                        POST /api/logout
                    </button>
                </div>
            </section>

            <!-- Step 2: Happy Path Endpoints -->
            <section class="bg-slate-900 border border-slate-800 rounded-xl p-5 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-emerald-400">2. Posts API Resource (Happy Paths)</h2>
                    <span class="text-xs bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 px-2 py-0.5 rounded">200 / 201 / 204</span>
                </div>

                <div class="space-y-2">
                    <button onclick="sendRequest('GET', '/api/posts')" class="w-full flex items-center justify-between bg-slate-950 hover:bg-slate-800/80 border border-slate-800 rounded-lg px-4 py-2.5 text-left transition">
                        <span class="flex items-center gap-2.5">
                            <span class="text-[11px] font-bold bg-sky-500/20 text-sky-400 px-2 py-0.5 rounded font-mono">GET</span>
                            <code class="text-xs font-mono text-slate-200">/api/posts</code>
                        </span>
                        <span class="text-xs text-slate-400">Paginated (200 OK)</span>
                    </button>

                    <div class="bg-slate-950 border border-slate-800 rounded-lg p-3 space-y-2">
                        <div class="grid grid-cols-1 gap-2 text-xs">
                            <input id="postTitle" type="text" value="My New RESTful Post" placeholder="Post Title" class="w-full bg-slate-900 border border-slate-800 rounded px-3 py-1.5 text-slate-100">
                            <input id="postBody" type="text" value="Created with Laravel Sanctum & PostResource!" placeholder="Post Body" class="w-full bg-slate-900 border border-slate-800 rounded px-3 py-1.5 text-slate-100">
                        </div>
                        <button onclick="createPost()" class="w-full flex items-center justify-between bg-emerald-600/20 hover:bg-emerald-600/30 border border-emerald-500/30 rounded-lg px-4 py-2 text-left transition">
                            <span class="flex items-center gap-2.5">
                                <span class="text-[11px] font-bold bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded font-mono">POST</span>
                                <code class="text-xs font-mono text-emerald-200">/api/posts</code>
                            </span>
                            <span class="text-xs text-emerald-300">Create (201 Created)</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-xs text-slate-400">Post ID:</label>
                        <input id="targetPostId" type="number" value="1" min="1" class="w-20 bg-slate-950 border border-slate-800 rounded px-2.5 py-1 text-xs font-mono text-white">
                        <button onclick="showPost()" class="flex-1 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-lg px-3 py-2 text-xs font-mono text-sky-400 transition">
                            GET /api/posts/{id}
                        </button>
                        <button onclick="updatePost()" class="flex-1 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-lg px-3 py-2 text-xs font-mono text-amber-400 transition">
                            PUT /api/posts/{id}
                        </button>
                        <button onclick="deletePost()" class="flex-1 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-lg px-3 py-2 text-xs font-mono text-rose-400 transition">
                            DELETE (204)
                        </button>
                    </div>
                </div>
            </section>

            <!-- Step 3: Sad Paths (Graded via Slide 10) -->
            <section class="bg-slate-900 border border-slate-800 rounded-xl p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-rose-400">3. Sad Paths (Slide 10 Grading)</h2>
                    <span class="text-xs bg-rose-500/10 text-rose-300 border border-rose-500/20 px-2 py-0.5 rounded">401 & 422</span>
                </div>

                <button onclick="sendRequest('GET', '/api/posts', null, true)" class="w-full flex items-center justify-between bg-slate-950 hover:bg-rose-950/30 border border-slate-800 hover:border-rose-500/40 rounded-lg px-4 py-2.5 text-left transition">
                    <span class="flex items-center gap-2.5">
                        <span class="text-[11px] font-bold bg-rose-500/20 text-rose-400 px-2 py-0.5 rounded font-mono">401</span>
                        <span class="text-xs text-slate-200">GET /api/posts <span class="text-slate-400">(Without Token)</span></span>
                    </span>
                    <span class="text-xs text-rose-400 font-mono">Unauthorized</span>
                </button>

                <button onclick="sendRequest('POST', '/api/posts', { title: '', body: '' })" class="w-full flex items-center justify-between bg-slate-950 hover:bg-amber-950/30 border border-slate-800 hover:border-amber-500/40 rounded-lg px-4 py-2.5 text-left transition">
                    <span class="flex items-center gap-2.5">
                        <span class="text-[11px] font-bold bg-amber-500/20 text-amber-400 px-2 py-0.5 rounded font-mono">422</span>
                        <span class="text-xs text-slate-200">POST /api/posts <span class="text-slate-400">(Empty Fields)</span></span>
                    </span>
                    <span class="text-xs text-amber-400 font-mono">Unprocessable</span>
                </button>

                <button onclick="sendRequest('GET', '/api/posts/99999')" class="w-full flex items-center justify-between bg-slate-950 hover:bg-orange-950/30 border border-slate-800 hover:border-orange-500/40 rounded-lg px-4 py-2.5 text-left transition">
                    <span class="flex items-center gap-2.5">
                        <span class="text-[11px] font-bold bg-orange-500/20 text-orange-400 px-2 py-0.5 rounded font-mono">404</span>
                        <span class="text-xs text-slate-200">GET /api/posts/99999 <span class="text-slate-400">(Missing ID)</span></span>
                    </span>
                    <span class="text-xs text-orange-400 font-mono">Not Found</span>
                </button>
            </section>
        </div>

        <!-- Right Column: Live JSON Inspector -->
        <div class="lg:col-span-7 flex flex-col">
            <div class="bg-slate-900 border border-slate-800 rounded-xl flex-1 flex flex-col overflow-hidden">
                <div class="border-b border-slate-800 px-5 py-3.5 flex items-center justify-between bg-slate-950/50">
                    <div class="flex items-center gap-3">
                        <span id="reqMethod" class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-slate-800 text-slate-300">READY</span>
                        <code id="reqUrl" class="text-xs font-mono text-slate-300">Click any endpoint on the left to inspect JSON</code>
                    </div>
                    <span id="statusBadge" class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-slate-800 text-slate-400">
                        Status: —
                    </span>
                </div>

                <div class="p-5 flex-1 overflow-auto">
                    <pre id="jsonOutput" class="text-xs font-mono text-emerald-300 leading-relaxed whitespace-pre-wrap">{
  "info": "Click 'POST /api/login' first to generate a Sanctum Bearer Token, or click '401 GET /api/posts (Without Token)' to test the sad path!"
}</pre>
                </div>
            </div>
        </div>
    </main>

    <script>
        let bearerToken = '';

        function updateTokenUI() {
            const el = document.getElementById('tokenDisplay');
            el.textContent = bearerToken ? bearerToken : 'None (Not Logged In)';
            el.className = bearerToken
                ? 'text-xs font-mono text-emerald-400 max-w-xs truncate'
                : 'text-xs font-mono text-amber-400 max-w-xs truncate';
        }

        function clearToken() {
            bearerToken = '';
            updateTokenUI();
        }

        async function sendRequest(method, url, body = null, skipToken = false) {
            document.getElementById('reqMethod').textContent = method;
            document.getElementById('reqUrl').textContent = url;
            document.getElementById('statusBadge').textContent = 'Sending...';

            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            };

            if (bearerToken && !skipToken) {
                headers['Authorization'] = 'Bearer ' + bearerToken;
            }

            const options = { method, headers };
            if (body !== null) {
                options.body = JSON.stringify(body);
            }

            try {
                const res = await fetch(url, options);
                const statusBadge = document.getElementById('statusBadge');
                statusBadge.textContent = `${res.status} ${res.statusText}`;

                if (res.status >= 200 && res.status < 300) {
                    statusBadge.className = 'text-xs font-mono font-bold px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
                } else if (res.status === 401 || res.status === 403) {
                    statusBadge.className = 'text-xs font-mono font-bold px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30';
                } else {
                    statusBadge.className = 'text-xs font-mono font-bold px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30';
                }

                if (res.status === 204) {
                    document.getElementById('jsonOutput').textContent = '// 204 No Content (Deleted successfully — empty body as required by REST)';
                    return null;
                }

                const data = await res.json();
                document.getElementById('jsonOutput').textContent = JSON.stringify(data, null, 2);
                return data;
            } catch (err) {
                document.getElementById('jsonOutput').textContent = 'Error: ' + err.message;
            }
        }

        async function loginApi() {
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const data = await sendRequest('POST', '/api/login', { email, password });
            if (data && data.token) {
                bearerToken = data.token;
                updateTokenUI();
            }
        }

        async function logoutApi() {
            await sendRequest('POST', '/api/logout');
            clearToken();
        }

        async function createPost() {
            const title = document.getElementById('postTitle').value;
            const body = document.getElementById('postBody').value;
            const data = await sendRequest('POST', '/api/posts', { title, body });
            if (data && data.data && data.data.id) {
                document.getElementById('targetPostId').value = data.data.id;
            }
        }

        function showPost() {
            const id = document.getElementById('targetPostId').value;
            sendRequest('GET', `/api/posts/${id}`);
        }

        function updatePost() {
            const id = document.getElementById('targetPostId').value;
            const title = document.getElementById('postTitle').value + ' (Updated)';
            const body = document.getElementById('postBody').value;
            sendRequest('PUT', `/api/posts/${id}`, { title, body });
        }

        function deletePost() {
            const id = document.getElementById('targetPostId').value;
            sendRequest('DELETE', `/api/posts/${id}`);
        }
    </script>
</body>
</html>
