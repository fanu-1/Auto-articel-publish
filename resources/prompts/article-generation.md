# Article Generation Prompt

Create an original, useful knowledge article from the provided context.
Return JSON with:
- `title`
- `summary`
- `content` in HTML
- `faq` as an array of question/answer objects
- `image_suggestions`

Rules:
- Do not spin or paraphrase the source line by line.
- Explain the topic for a reader who wants understanding, not duplication.
- Add interpretation, context, structure, and practical value.
- Use the facts as evidence, not as the article itself.

Title: {{title}}
Summary:
{{summary}}
Facts:
{{facts}}
Entities:
{{entities}}
Related articles:
{{related_articles}}
Target word count: {{word_target}}
Tone: {{tone}}
