<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Resume Analyzer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#F6F7FB] text-slate-900">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute -top-40 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-indigo-200/40 blur-3xl"></div>
            <div class="absolute top-20 right-0 h-96 w-96 rounded-full bg-blue-200/40 blur-3xl"></div>
        </div>

        <header class="mx-auto flex max-w-6xl items-center justify-between px-6 py-6">
            <div class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-2xl bg-slate-950 text-white shadow-lg">
                    AI
                </div>
                <div>
                    <h1 class="text-lg font-bold">ResumeIQ</h1>
                    <p class="text-xs text-slate-500">AI Resume Analyzer</p>
                </div>
            </div>

            <span class="rounded-full border border-slate-200 bg-white/70 px-4 py-2 text-sm text-slate-600 shadow-sm backdrop-blur">
                Powered by Laravel AI
            </span>
        </header>

        <main class="mx-auto grid max-w-6xl gap-10 px-6 pb-16 pt-8 lg:grid-cols-[1fr_440px] lg:items-center">
            <section>

                <h2 class="mt-6 max-w-3xl text-5xl font-extrabold tracking-tight text-slate-950 md:text-6xl">
                    Analyze your resume with AI in seconds.
                </h2>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                    Upload your PDF resume and get a professional review, ATS score, missing keywords,
                    strengths, weaknesses, and a rewritten profile summary.
                </p>

                <div class="mt-8 grid max-w-2xl gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                        <p class="text-2xl font-bold">ATS</p>
                        <p class="mt-1 text-sm text-slate-500">Score check</p>
                    </div>
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                        <p class="text-2xl font-bold">AI</p>
                        <p class="mt-1 text-sm text-slate-500">Resume review</p>
                    </div>
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                        <p class="text-2xl font-bold">PDF</p>
                        <p class="mt-1 text-sm text-slate-500">Upload parser</p>
                    </div>
                </div>
            </section>

            <form
                    method="POST"
                    action="{{ route('resume.analyze') }}"
                    enctype="multipart/form-data"
                    class="space-y-5"
                    id="resumeForm"
                >
                <div class="mb-6">
                    <h3 class="text-2xl font-bold">Upload resume</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        PDF only. Add a job description for targeted analysis.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('resume.analyze') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold">Resume PDF</span>
                        <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center transition hover:border-indigo-400 hover:bg-indigo-50/40">
                            <input
                                type="file"
                                name="resume"
                                accept="application/pdf"
                                required
                                class="mx-auto block w-full cursor-pointer text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-slate-950 file:px-5 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-700"
                            >
                            <p class="mt-3 text-xs text-slate-500">Max file size: 5MB</p>
                        </div>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold">Job Description Optional</span>
                        <textarea
                            name="job_description"
                            rows="7"
                            class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-100"
                            placeholder="Paste the job description here to get keyword and role-specific suggestions..."
                        ></textarea>
                    </label>

                    <button
    type="submit"
    id="analyzeBtn"
    class="group flex w-full items-center justify-center gap-3 rounded-3xl bg-slate-950 px-6 py-4 text-sm font-black text-white shadow-xl shadow-slate-300 transition hover:-translate-y-0.5 hover:bg-indigo-600 disabled:cursor-not-allowed disabled:opacity-80"
>
    <svg
        id="loadingIcon"
        class="hidden h-5 w-5 animate-spin text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
    >
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>

    <span id="buttonText">Analyze Resume</span>
    <span id="buttonArrow" class="transition group-hover:translate-x-1">→</span>
</button>
                </form>
            </section>
        </main>
    </div>

    <script>
    const form = document.getElementById('resumeForm');
    const button = document.getElementById('analyzeBtn');
    const buttonText = document.getElementById('buttonText');
    const buttonArrow = document.getElementById('buttonArrow');
    const loadingIcon = document.getElementById('loadingIcon');

    form.addEventListener('submit', function () {
        button.disabled = true;
        buttonText.textContent = 'Analyzing resume with AI...';
        buttonArrow.classList.add('hidden');
        loadingIcon.classList.remove('hidden');
    });
</script>
</body>
</html>