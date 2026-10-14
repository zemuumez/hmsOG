import { ActionLink, Container, PageHeading } from "@/components/ui";

export default function NotFound() {
  return <Container className="py-24"><PageHeading eyebrow="404" title="Page not found" description="The page may have moved or the address may be incorrect." /><ActionLink href="/" className="mt-8">Back to home</ActionLink></Container>;
}
