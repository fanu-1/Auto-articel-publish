# Fact Extraction Prompt

Extract only verifiable facts from the source material.
Return JSON with:
- `facts`: array of concise factual statements
- `summary`: a short neutral summary
- `confidence`: number from 0 to 100

Rules:
- Do not rewrite the source.
- Do not invent claims.
- Prefer concrete names, dates, places, numbers, and relationships.
- Remove speculation and promotional language.

Source title: {{title}}
Source text:
{{content}}
