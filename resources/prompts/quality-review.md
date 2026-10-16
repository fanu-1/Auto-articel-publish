# Quality Review Prompt

Review the article for quality and usefulness.
Return JSON with:
- `score` from 0 to 100
- `approved` boolean
- `notes` array of issues or strengths

Rules:
- Judge originality, clarity, usefulness, structure, and factual discipline.
- Reject content that reads like a spinner or a shallow rewrite.
- Prefer knowledge transformation over repetition.

Article:
{{content}}
