# PropStream List-Build + Letter-to-PDF Workflow

This repo now contains a practical workflow you can follow to use your **PropStream** subscription to:

1. Build highly targeted lead lists (10+ year owners, absentee, small multifamily, distress/vacant, tax liens).
2. Export records in a usable format.
3. Draft personalized letters.
4. Merge letters and addresses.
5. Generate a print-ready PDF for your copy machine.

---

## 1) Build your target list(s) in PropStream

Start with a county/city/ZIP and apply filters in this order so you can narrow quickly.

### A. Base ownership filters
- **Ownership Time:** set to **10+ years**.
- **Owner Occupancy:** choose **Absentee Owner = Yes**.
- **Property Type:** include **2–4 unit / small multifamily** (or your exact buy box).

### B. Distress filters (stack as needed)
Use one or multiple depending on your strategy:
- **Vacant**
- **Tax Delinquent / Tax Lien**
- **Pre-foreclosure**
- **Free & Clear or High Equity** (optional quality filter)

### C. Exclusions (recommended)
- Exclude records with missing mailing address.
- Exclude owner-occupied if you only want absentee.
- Exclude properties outside your unit count/price range.

### D. Save segmented lists (don’t mix everything into one)
Create separate saved lists for better message-market match:
- `10yr_absentee_small_mf`
- `vacant_absentee_10yr`
- `tax_lien_10yr_absentee`
- `distress_small_mf_owners`

> Why segmentation matters: your letter copy can speak directly to the owner’s likely pain point (vacancy, tax pressure, tired landlord, etc.).

---

## 2) Export lead data from PropStream

Export to **CSV** with fields needed for mail merge:
- Owner first/last name (or entity name)
- Property address (subject property)
- Mailing address (recipient address)
- City, state, ZIP
- APN (optional for internal tracking)
- Any tag/list name field

Keep one CSV per campaign/list so your response tracking stays clean.

---

## 3) Prepare the mailing file

Open CSV in Excel/Google Sheets and do a quick clean-up:
- Remove duplicate mailing addresses.
- Normalize name capitalization.
- Keep columns with consistent headers, for example:
  - `owner_name`
  - `mail_street`
  - `mail_city`
  - `mail_state`
  - `mail_zip`
  - `property_street`
  - `property_city`
  - `property_state`
  - `property_zip`
  - `list_name`

Save as UTF-8 CSV.

---

## 4) Letter templates you can use immediately

Use one core letter and lightly customize by segment.

### Template A: Absentee / 10+ year owner

**Subject:** Quick question about your property at {{property_street}}

Hi {{owner_name}},

I’m reaching out because I’m looking to buy a property in the area, and your property at {{property_street}} came up in my search.

If you’ve considered selling—now or later—I can make a straightforward offer, buy as-is, and work on your timeline.

No pressure at all. If you’d like, call or text me at {{your_phone}} and I can share what I could offer.

Sincerely,  
{{your_name}}  
{{your_phone}}  
{{your_email}}

---

### Template B: Vacant / distressed angle

**Subject:** Property at {{property_street}}

Hi {{owner_name}},

I noticed your property at {{property_street}} and wanted to ask if you’d consider an as-is sale.

I buy properties in their current condition and can handle a fast, simple closing if that helps.

If you’re open to a conversation, call or text me at {{your_phone}}.

Thank you,  
{{your_name}}  
{{your_phone}}

---

### Template C: Tax-lien pressure relief angle

**Subject:** Option for your property at {{property_street}}

Hi {{owner_name}},

I work with owners who want an easy sale option for properties they no longer want to manage.

If it would help to discuss selling your property at {{property_street}}, I can make a fair as-is offer and close on your schedule.

If you want to compare options, call/text me at {{your_phone}}.

Best,  
{{your_name}}  
{{your_phone}}

---

## 5) Merge letters and generate one print-ready PDF

You have two reliable options:

### Option 1 (easiest): Microsoft Word Mail Merge
1. Open Word template letter.
2. **Mailings → Start Mail Merge → Letters**.
3. **Select Recipients → Use Existing List** (your CSV).
4. Insert merge fields (name/address/property).
5. Preview results.
6. **Finish & Merge → Edit Individual Documents**.
7. Save final combined file as **PDF**.

### Option 2: Google Docs + add-on (or Apps Script)
1. Keep data in Google Sheets.
2. Use a mail merge add-on to fill a Google Doc template.
3. Export merged doc to PDF.

For copy machine printing, keep output as:
- US Letter (8.5 x 11)
- Single-sided unless your workflow uses duplex
- Standard margins compatible with #10 envelopes

---

## 6) Print package checklist

Before printing:
- [ ] Spot-check 20 random records for address quality.
- [ ] Remove obvious deceased/duplicate/entity anomalies as needed.
- [ ] Confirm phone/email in signature block.
- [ ] Ensure date is current.
- [ ] Export one combined PDF and archive the source CSV.

After printing:
- [ ] Record campaign name, mail date, and record count.
- [ ] Track inbound calls/texts by list segment.

---

## 7) Compliance & quality notes

- Marketing and solicitation rules vary by state/county/city; verify local requirements before mailing.
- Real estate data can lag. For high-value prospects, verify status (ownership, taxes, vacancy) before deep follow-up.

---

## 8) PropStream resources used for this playbook

- How to find absentee owners with PropStream:
  - https://www.propstream.com/news/how-to-find-absentee-owners-with-propstream
- PropStream quick lists (including lien/vacant context):
  - https://www.propstream.com/news/propstreams-quick-lists
- Vacant property list workflow:
  - https://updates.propstream.com/vacant-and-abandoned-properties
- Mailing labels workflow:
  - https://www.propstream.com/how-to-create-mailing-labels-in-propstream

