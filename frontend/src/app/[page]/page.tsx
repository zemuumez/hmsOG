import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { DoctorGrid, ServiceGrid } from "@/components/catalog";
import { ActionLink, Card, Container, EmptyState, PageHeading } from "@/components/ui";
import { getWebsite } from "@/lib/website";
import { laravelUrl } from "@/lib/links";

const pages: Record<string, { title: string; description: string }> = {
  "our-services": { title: "Care for your needs", description: "Explore the services available at our hospital." },
  "our-doctors": { title: "Meet your care team", description: "Find a doctor and learn about their area of practice." },
  "about-us": { title: "About our hospital", description: "Get to know our hospital and our approach to care." },
  "contact-us": { title: "Let’s talk", description: "Contact our team for help planning your visit." },
  "working-hours": { title: "Plan your visit", description: "View our hospital’s working hours." },
  "testimonial": { title: "Patient experiences", description: "Hear from people who have visited our hospital." },
  "privacy-policy": { title: "Privacy policy", description: "How the hospital handles your information." },
  "terms-of-service": { title: "Terms of service", description: "Terms for using our services." },
  "appointment": { title: "Book an appointment", description: "Choose your doctor and an available time through our hospital booking service." },
};

type Props = { params: Promise<{ page: string }> };

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { page } = await params;
  return { title: pages[page]?.title || "Page not found" };
}

export default async function WebsitePage({ params }: Props) {
  const { page } = await params;
  if (!Object.hasOwn(pages, page)) notFound();
  const { data } = await getWebsite();
  const info = pages[page];
  return <Container className="py-14 sm:py-20"><PageHeading eyebrow="Your hospital" {...info} /><div className="mt-12">
    {page === "our-services" && <ServiceGrid services={data.services} />}
    {page === "our-doctors" && <DoctorGrid doctors={data.doctors} />}
    {page === "about-us" && <div className="grid gap-6 md:grid-cols-2"><Card><h2 className="text-2xl font-semibold text-slate-950">{data.content.about_us_title || "Our hospital"}</h2><p className="mt-5 whitespace-pre-line leading-8">{data.content.about_us_description || "Contact our team to learn more about the hospital and the services available."}</p></Card><Card><h2 className="text-2xl font-semibold text-slate-950">Our mission</h2><p className="mt-5 whitespace-pre-line leading-8">{data.content.about_us_mission || "Hospital information will appear here when available."}</p></Card></div>}
    {page === "contact-us" && <div className="grid gap-6 md:grid-cols-2"><Card><h2 className="text-2xl font-semibold text-slate-950">Get in touch</h2><dl className="mt-7 space-y-6">{[["Phone", data.settings.hospital_phone], ["Email", data.settings.hospital_email], ["Address", data.settings.hospital_address]].map(([label, value]) => <div key={label}><dt className="text-xs font-bold uppercase tracking-wider text-teal-800">{label}</dt><dd className="mt-2 break-words">{value || "Not currently available"}</dd></div>)}</dl></Card><Card><h2 className="text-2xl font-semibold text-slate-950">Send an enquiry</h2><p className="my-5 leading-7">Use our hospital enquiry form for questions or feedback. The form opens on the hospital service.</p><ActionLink href={laravelUrl("/contact-us")}>Open enquiry form ↗</ActionLink></Card></div>}
    {page === "working-hours" && <Card className="max-w-3xl">{data.hours.length ? <dl className="divide-y divide-slate-100">{data.hours.map(hour => <div key={hour.day} className="flex flex-wrap justify-between gap-3 py-5"><dt className="font-semibold text-slate-950">{hour.day}</dt><dd>{hour.start && hour.end && hour.start !== hour.end ? `${hour.start} – ${hour.end}` : "Closed"}</dd></div>)}</dl> : <p>Working hours are currently unavailable. Please contact the hospital before visiting.</p>}</Card>}
    {page === "testimonial" && <div className="grid gap-6 md:grid-cols-2">{data.testimonials.length ? data.testimonials.map(item => <Card key={item.id}><blockquote><p className="whitespace-pre-line text-lg leading-8">{item.description}</p><footer className="mt-6 font-semibold text-teal-800">{item.name}</footer></blockquote></Card>) : <EmptyState>No testimonials are currently available.</EmptyState>}</div>}
    {["privacy-policy", "terms-of-service"].includes(page) && <Card className="max-w-4xl"><p className="whitespace-pre-line leading-8">{data.content[page === "privacy-policy" ? "privacy_policy" : "terms_conditions"] || "This information is currently unavailable. Please contact the hospital for a copy."}</p></Card>}
    {page === "appointment" && <Card className="max-w-2xl"><h2 className="text-2xl font-semibold text-slate-950">Continue to hospital booking</h2><p className="my-5 leading-7">The hospital booking service handles doctor availability, your details, and any required payment. Your appointment is confirmed there.</p><ActionLink href={laravelUrl("/appointment")}>Choose a time ↗</ActionLink></Card>}
  </div></Container>;
}
