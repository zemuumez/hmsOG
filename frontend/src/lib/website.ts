import "server-only";
import { cache } from "react";

export type Service = { id: number; name: string; description: string };
export type Doctor = { id: number; name: string; department: string; specialist: string; qualification: string };
export type Website = {
  settings: Record<string, string>;
  content: Record<string, string>;
  services: Service[];
  doctors: Doctor[];
  testimonials: { id: number; name: string; description: string }[];
  hours: { day: string; start: string | null; end: string | null }[];
};

export type WebsiteResult = { data: Website; available: boolean };

// Requests are deduplicated within a render, never cached across patients or requests.
export const getWebsite = cache(async (): Promise<WebsiteResult> => {
  try {
    const origin = process.env.LARAVEL_URL || "http://127.0.0.1:8000";
    const response = await fetch(new URL("/api/public/website", origin), {
      headers: { Accept: "application/json" },
      cache: "no-store",
      signal: AbortSignal.timeout(8000),
    });
    if (!response.ok) throw new Error("Website API unavailable");
    const { data } = await response.json();
    if (!data || !data.settings || !data.content ||
        ![data.services, data.doctors, data.testimonials, data.hours].every(Array.isArray)) {
      throw new Error("Invalid website response");
    }
    return { data, available: true };
  } catch {
    return { available: false, data: {
      settings: {}, content: {}, services: [], doctors: [], testimonials: [], hours: [],
    } };
  }
});
