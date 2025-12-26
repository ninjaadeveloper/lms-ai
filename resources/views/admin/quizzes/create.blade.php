@extends('../admin.layout')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">

                <div class="card shadow-sm mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Generate Quiz</h4>
                            <div class="text-muted">
                                Course: <strong>{{ $course->title }}</strong>
                            </div>
                        </div>

                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.courses.show', $course->id) : route('trainer.courses.show', $course->id) }}"
                            class="btn btn-light">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-5 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">AI Generator</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Topic</label>
                                    <input id="topic" type="text" class="form-control"
                                        placeholder="e.g. Variables, OOP, SQL Joins">
                                </div>

                                <div class="form-group">
                                    <label>Generate how many MCQs?</label>
                                    <input id="count" type="number" class="form-control" min="1" max="20" value="10">
                                    <small class="text-muted">You can generate up to 20, but you can select only max 10 to
                                        save.</small>
                                </div>

                                <button id="btnGenerate" class="btn btn-primary">
                                    <i class="fas fa-magic mr-1"></i> Generate
                                </button>

                                <button id="btnMore" class="btn btn-outline-secondary ml-2" disabled>
                                    Generate More
                                </button>

                                <div id="genStatus" class="mt-3 text-muted"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Generated MCQs</h5>
                                <div>
                                    <span class="badge badge-light">Selected: <span id="selCount">0</span>/10</span>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width:60px;">Pick</th>
                                                <th>Question</th>
                                            </tr>
                                        </thead>
                                        <tbody id="mcqBody">
                                            <tr>
                                                <td colspan="2" class="text-center text-muted py-4">Generate MCQs to see
                                                    them here.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <small class="text-muted">Select max 10 questions, then save.</small>

                                <form id="saveForm" method="POST" action="{{ auth()->user()->role === 'admin'
        ? route('admin.courses.quizzes.store', $course->id)
        : route('trainer.courses.quizzes.store', $course->id) }}">
                                    @csrf
                                    <input type="hidden" name="topic" id="topicHidden">
                                    <input type="hidden" name="selected" id="selectedHidden">
                                    <button type="submit" class="btn btn-success" id="btnSave" disabled>
                                        <i class="fas fa-save mr-1"></i> Save Selected
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const generateUrl = "{{ auth()->user()->role === 'admin'
        ? route('admin.courses.quizzes.generate', $course->id)
        : route('trainer.courses.quizzes.generate', $course->id) }}";
        const csrf = "{{ csrf_token() }}";

        let pool = [];         // all generated items
        let selectedIds = new Set();

        function setStatus(t) { document.getElementById('genStatus').innerText = t || ''; }

        function selectedCount() { return selectedIds.size; }

        function render() {
            const body = document.getElementById('mcqBody');
            const selCountEl = document.getElementById('selCount');
            selCountEl.innerText = selectedCount();

            if (!pool.length) {
                body.innerHTML = `<tr><td colspan="2" class="text-center text-muted py-4">Generate MCQs to see them here.</td></tr>`;
                document.getElementById('btnSave').disabled = true;
                return;
            }

            body.innerHTML = pool.map((q, idx) => {
                const checked = selectedIds.has(q.id) ? 'checked' : '';
                return `
                            <tr>
                              <td class="text-center">
                                <input type="checkbox" class="pick" data-id="${q.id}" ${checked}/>
                              </td>
                              <td>
                                <div class="font-weight-bold">${idx + 1}. ${escapeHtml(q.question)}</div>
                                <div class="text-muted mt-2">
                                  <div><strong>A:</strong> ${escapeHtml(q.A)}</div>
                                  <div><strong>B:</strong> ${escapeHtml(q.B)}</div>
                                  <div><strong>C:</strong> ${escapeHtml(q.C)}</div>
                                  <div><strong>D:</strong> ${escapeHtml(q.D)}</div>
                                  <div class="mt-1"><span class="badge badge-light">Answer: ${escapeHtml(q.answer)}</span></div>
                                </div>
                              </td>
                            </tr>
                          `;
            }).join('');

            document.querySelectorAll('.pick').forEach(cb => {
                cb.addEventListener('change', (e) => {
                    const id = e.target.dataset.id;

                    if (e.target.checked) {
                        if (selectedCount() >= 10) {
                            e.target.checked = false;
                            alert('Max 10 questions can be selected.');
                            return;
                        }
                        selectedIds.add(id);
                    } else {
                        selectedIds.delete(id);
                    }

                    document.getElementById('selCount').innerText = selectedCount();
                    document.getElementById('btnSave').disabled = selectedCount() === 0;
                });
            });

            document.getElementById('btnSave').disabled = selectedCount() === 0;
        }

        function escapeHtml(str) {
            return (str ?? '').toString()
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", "&#039;");
        }

        async function generate(mode = 'new') {
            const topic = document.getElementById('topic').value.trim();
            const count = Number(document.getElementById('count').value || 10);

            if (!topic) { alert('Please enter topic'); return; }

            const btnGenerate = document.getElementById('btnGenerate');
            const btnMore = document.getElementById('btnMore');

            btnGenerate.disabled = true;
            btnMore.disabled = true;
            setStatus('Generating...');

            try {
                const res = await fetch(generateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ topic, count })
                });

                const rawText = await res.text(); // 👈 raw response
                console.log('=== GENERATE RAW RESPONSE ===');
                console.log('status:', res.status);
                console.log(rawText);

                let json = null;
                try { json = JSON.parse(rawText); } catch (e) { json = null; }

                console.log('=== GENERATE JSON PARSED ===');
                console.log(json);

                if (!res.ok || !json || !json.ok) {
                    setStatus('Failed to generate. Check console for full response.');
                    return;
                }

                // optional: debug info from backend
                if (json.debug) {
                    console.log('=== BACKEND DEBUG ===');
                    console.log(json.debug);
                }

                const items = Array.isArray(json.items) ? json.items : [];

                if (mode === 'new') {
                    pool = items;
                    selectedIds = new Set();
                } else {
                    pool = pool.concat(items);
                }

                setStatus(`Generated: ${items.length} items`);
                render();

            } catch (err) {
                console.error('Generate error:', err);
                setStatus('Generate crashed. Check console.');
            } finally {
                btnGenerate.disabled = false;
                btnMore.disabled = false;
            }
        }


        document.getElementById('btnGenerate').addEventListener('click', () => generate('new'));
        document.getElementById('btnMore').addEventListener('click', () => generate('more'));

        // on save: pack selected objects
        document.getElementById('saveForm').addEventListener('submit', (e) => {
            const topic = document.getElementById('topic').value.trim();
            if (!topic) { e.preventDefault(); alert('Topic required'); return; }

            const selected = pool.filter(q => selectedIds.has(q.id)).slice(0, 10);

            if (!selected.length) {
                e.preventDefault();
                alert('Please select at least 1 question.');
                return;
            }

            document.getElementById('topicHidden').value = topic;
            document.getElementById('selectedHidden').value = JSON.stringify(selected);
        });

        render();
    </script>
@endpush