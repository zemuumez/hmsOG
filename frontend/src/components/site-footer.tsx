import Link from "next/link";
import { Container } from "@/components/ui";

export function SiteFooter({ name }: { name: string }) {
  return <footer className="mt-auto border-t border-slate-200 bg-white py-10"><Container className="flex flex-col justify-between gap-6 sm:flex-row"><div><p className="font-semibold text-slate-950">{name}</p><p className="mt-2 text-sm text-slate-500">Care begins with a conversation.</p></div><nav aria-label="Footer navigation" className="flex flex-wrap gap-x-6 gap-y-3 text-sm text-slate-600">{[["/working-hours", "Working hours"], ["/testimonial", "Testimonials"], ["/privacy-policy", "Privacy"], ["/terms-of-service", "Terms"]].map(([href, label]) => <Link key={href} href={href} className="hover:text-teal-800">{label}</Link>)}</nav></Container></footer>;
}
