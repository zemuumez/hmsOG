import type { Metadata } from "next";
import type { ReactNode } from "react";
import { SiteHeader } from "@/components/site-header";
import { SiteFooter } from "@/components/site-footer";
import { Container } from "@/components/ui";
import { getWebsite } from "@/lib/website";
import "./globals.css";

export const metadata: Metadata = {
  title: { default: "Hospital | Care for every day", template: "%s | Hospital" },
  description: "Find hospital services, meet our doctors, and plan your visit.",
};

export default async function RootLayout({ children }: { children: ReactNode }) {
  const { data, available } = await getWebsite();
  const name = data.settings.app_name || "Hospital";
  return <html lang="en"><body className="flex min-h-screen flex-col antialiased">
    <a href="#main-content" className="sr-only z-50 rounded bg-white p-4 focus:not-sr-only focus:absolute">Skip to content</a>
    <SiteHeader name={name} />
    {!available && <div role="status" className="border-b border-amber-200 bg-amber-50 py-3 text-sm text-amber-950"><Container>Hospital information is temporarily unavailable. Please try again shortly.</Container></div>}
    <main id="main-content" className="flex-1">{children}</main>
    <SiteFooter name={name} />
  </body></html>;
}
