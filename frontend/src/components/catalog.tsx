import Link from "next/link";
import type { Doctor, Service } from "@/lib/website";
import { Card, EmptyState } from "@/components/ui";

export function ServiceGrid({ services }: { services: Service[] }) {
  return <div className="grid gap-5 md:grid-cols-2 lg:grid-cols-3">{services.length ? services.map(service => <Card key={service.id}><span aria-hidden="true" className="mb-7 inline-flex size-11 items-center justify-center rounded-xl bg-teal-50 text-2xl text-teal-800">+</span><h2 className="text-xl font-semibold text-slate-950">{service.name}</h2><p className="mt-3 leading-7 text-slate-600">{service.description}</p></Card>) : <EmptyState>No services are available to display. Please contact the hospital for assistance.</EmptyState>}</div>;
}

export function DoctorGrid({ doctors }: { doctors: Doctor[] }) {
  return <div className="grid gap-5 md:grid-cols-2 lg:grid-cols-3">{doctors.length ? doctors.map(doctor => <Card key={doctor.id}><div aria-hidden="true" className="mb-6 flex size-16 items-center justify-center rounded-2xl bg-teal-50 text-xl font-semibold text-teal-800">{doctor.name.split(/\s+/).slice(0, 2).map(part => part[0]).join("")}</div><p className="text-xs font-semibold uppercase tracking-wider text-teal-800">{doctor.department || doctor.specialist}</p><h2 className="mt-2 text-xl font-semibold"><Link href={`/doctor-details/${doctor.id}`} className="hover:text-teal-800">{doctor.name}</Link></h2><p className="mt-2 text-sm text-slate-600">{doctor.qualification}</p><Link href={`/doctor-details/${doctor.id}`} className="mt-6 inline-block text-sm font-semibold text-teal-800">View profile <span aria-hidden="true">↗</span></Link></Card>) : <EmptyState>No doctors are available to display. Please contact the hospital for assistance.</EmptyState>}</div>;
}
