# FAQ Generation Prompt

Generate concise FAQs that help a reader understand the topic better.
Return JSON with:
- `faqs`: array of question/answer objects

Rules:
- Questions must be useful and specific.
- Answers must be short, accurate, and knowledge-first.
- Avoid repeating the article content verbatim.

Context:
{{content}}
