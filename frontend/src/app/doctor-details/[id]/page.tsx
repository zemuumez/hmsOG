import { notFound } from "next/navigation";
import { ActionLink, Card, Container, PageHeading } from "@/components/ui";
import { getWebsite } from "@/lib/website";
import { laravelUrl } from "@/lib/links";

export default async function DoctorDetails({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const { data, available } = await getWebsite();
  if (!available) return <Container className="py-20"><PageHeading eyebrow="Our doctors" title="Doctor information is unavailable" description="Please try again shortly or contact the hospital." /></Container>;
  const doctor = data.doctors.find(item => String(item.id) === id);
  if (!doctor) notFound();
  return <Container className="py-20"><PageHeading eyebrow={doctor.department || "Our doctors"} title={doctor.name} description={doctor.specialist} /><Card className="mt-10 max-w-2xl"><h2 className="text-xl font-semibold">Qualifications</h2><p className="mt-4">{doctor.qualification || "Contact the hospital for details."}</p><div className="mt-8 flex flex-wrap gap-3"><ActionLink href={laravelUrl(`/doctor-details/${doctor.id}`)}>View schedule and book ↗</ActionLink><ActionLink href="/our-doctors" secondary>All doctors</ActionLink></div></Card></Container>;
}
