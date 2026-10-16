# SEO Generation Prompt

Create SEO metadata for the article.
Return JSON with:
- `seo_title`
- `seo_description`
- `seo_keywords` as an array

Rules:
- Keep the title readable and clickable.
- Keep the description clear, useful, and under 160 characters.
- Keywords should be relevant and not spammy.

Title: {{title}}
Summary:
{{summary}}
Content:
{{content}}
