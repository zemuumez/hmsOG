import Link from "next/link";
import type { ComponentProps, ReactNode } from "react";

export function Container({ children, className = "" }: { children: ReactNode; className?: string }) {
  return <div className={`mx-auto w-full max-w-7xl px-5 sm:px-8 ${className}`}>{children}</div>;
}

export function Card({ children, className = "" }: { children: ReactNode; className?: string }) {
  return <div className={`rounded-2xl border border-slate-200 bg-white p-7 ${className}`}>{children}</div>;
}

export function ActionLink({ children, secondary = false, className = "", ...props }: ComponentProps<typeof Link> & { secondary?: boolean }) {
  return <Link className={`inline-flex min-h-12 items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold transition-colors ${secondary ? "border border-slate-300 bg-white text-slate-800 hover:bg-slate-100" : "bg-teal-800 text-white hover:bg-teal-950"} ${className}`} {...props}>{children}</Link>;
}

export function PageHeading({ eyebrow, title, description }: { eyebrow: string; title: string; description?: string }) {
  return <div className="max-w-3xl"><p className="mb-4 text-xs font-bold uppercase tracking-[0.18em] text-teal-800">{eyebrow}</p><h1 className="text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">{title}</h1>{description && <p className="mt-5 text-lg leading-8 text-slate-600">{description}</p>}</div>;
}

export function EmptyState({ children }: { children: ReactNode }) {
  return <Card className="col-span-full text-slate-600">{children}</Card>;
}
