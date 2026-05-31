#!/usr/bin/env python3
import json, os, shutil, sys

def build():
    pages_path = 'data/pages.json'
    if not os.path.exists(pages_path):
        print("ERROR: pages.json not found")
        sys.exit(1)
    with open(pages_path, 'r') as f:
        pages = json.load(f)
    with open('theme/base.html', 'r') as f:
        template = f.read()
    if os.path.exists('build'):
        shutil.rmtree('build')
    os.makedirs('build')
    for page in pages:
        slug = page['slug']
        content = page.get('body_content', '')
        title = page.get('title', 'White Rose House Clearance')
        description = page.get('description', 'Professional house clearance across Yorkshire. Fully licensed, eco-friendly and compassionate. Free same-day quotes.')
        html = template.replace('{{ content }}', content)
        html = html.replace('{{ title }}', title)
        html = html.replace('{{ description }}', description)
        out_dir = os.path.join('build', slug) if slug else 'build'
        os.makedirs(out_dir, exist_ok=True)
        with open(os.path.join(out_dir, 'index.html'), 'w') as f:
            f.write(html)
    if os.path.exists('assets'):
        shutil.copytree('assets', 'build/assets', dirs_exist_ok=True)
    for f in ['.htaccess', 'robots.txt', 'send-quote.php']:
        src = os.path.join('assets', f)
        if os.path.exists(src):
            shutil.copy2(src, os.path.join('build', f))
            print(f"Copied {f} to build/")
    print(f"Built {len(pages)} pages")

if __name__ == '__main__':
    build()
