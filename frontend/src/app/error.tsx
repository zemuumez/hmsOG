"use client";

export default function ErrorPage({ reset }: { reset: () => void }) {
  return <div role="alert" className="mx-auto max-w-3xl px-6 py-24"><h1 className="text-3xl font-semibold text-slate-950">We couldn’t load this page</h1><p className="mt-4">Please try again.</p><button onClick={reset} className="mt-6 rounded-xl bg-teal-800 px-5 py-3 font-semibold text-white">Try again</button></div>;
}
