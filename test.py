from openai import OpenAI
import json
import re

client = OpenAI(
  base_url="https://openrouter.ai/api/v1",
  api_key="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",
)
#{"role": "system", "content": "You are a JSON generator. Respond ONLY with valid JSON. Do not include any extra text."},
def make_request(decease):
    completion = client.chat.completions.create(
        extra_headers={ "X-Title": "Plant Decease Detection" },
        model="z-ai/glm-4.5-air:free",
        messages=[
            {"role": "system", "content": "You are a JSON generator. Respond ONLY with valid JSON."},
            {"role": "user", "content": f"What is the suitable solution for {decease} disease? Return the answer as JSON."}
        ]
    )

    content = completion.choices[0].message.content.strip()
    try:
        return json.loads(content)
    except json.JSONDecodeError:
        m = re.search(r'(\{.*\}|\[.*\])', content, re.S)
        if m:
            try:
                return json.loads(m.group(1))
            except json.JSONDecodeError:
                pass
    return {"raw_response": content}

if __name__ == "__main__":
    result = make_request("Tomato_Early_blight")
    print(json.dumps(result, indent=2))
