"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useState } from "react";
import { laravelUrl, navigation } from "@/lib/links";
import { Container } from "@/components/ui";

export function SiteHeader({ name }: { name: string }) {
  const pathname = usePathname();
  const [open, setOpen] = useState(false);
  return <header className="border-b border-slate-200 bg-white">
    <Container className="flex min-h-24 flex-wrap items-center justify-between gap-4 py-4">
      <Link href="/" onClick={() => setOpen(false)} className="flex items-center gap-3 font-bold tracking-tight text-slate-950"><span aria-hidden="true" className="flex size-10 items-center justify-center rounded-xl bg-teal-800 text-3xl font-normal text-white">+</span><span className="max-w-48 text-lg">{name}</span></Link>
      <button type="button" aria-expanded={open} aria-controls="site-navigation" onClick={() => setOpen(!open)} className="rounded-lg border border-slate-300 px-4 py-2 text-sm lg:hidden">{open ? "Close menu" : "Menu"}</button>
      <nav id="site-navigation" aria-label="Main navigation" className={`${open ? "flex" : "hidden"} w-full flex-col gap-2 lg:flex lg:w-auto lg:flex-row lg:items-center lg:gap-5`}>
        {navigation.map(item => <Link key={item.href} href={item.href} onClick={() => setOpen(false)} aria-current={pathname === item.href ? "page" : undefined} className={`rounded-lg px-2 py-3 text-sm font-medium ${pathname === item.href ? "text-teal-800 underline decoration-2 underline-offset-8" : "text-slate-600 hover:text-teal-800"}`}>{item.label}</Link>)}
        <a href={laravelUrl("/login")} className="rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-semibold">Portal sign in</a>
      </nav>
    </Container>
  </header>;
}
