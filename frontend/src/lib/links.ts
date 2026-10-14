export function laravelUrl(path: string): string {
  const origin = process.env.NEXT_PUBLIC_LARAVEL_URL || "http://127.0.0.1:8000";
  return new URL(path, origin).toString();
}

export const navigation = [
  { href: "/", label: "Home" },
  { href: "/our-services", label: "Services" },
  { href: "/our-doctors", label: "Doctors" },
  { href: "/about-us", label: "About us" },
  { href: "/contact-us", label: "Contact" },
];
