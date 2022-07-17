import speech_recognition
import spacy
from spacy.lang.en.stop_words import STOP_WORDS
from string import punctuation
from heapq import nlargest
from newspaper import Article



def record_voice():
    microphone = speech_recognition.Recognizer()
    file = open('you_said_this.txt', 'a+')
    with speech_recognition.Microphone() as live_phone:
        microphone.adjust_for_ambient_noise(live_phone)
        print("I'm trying to hear you: ")
        audio = microphone.listen(live_phone)
        try:
            phrase = microphone.recognize_google(audio, language='en')
            file.write(phrase)
            print('the last sentence you spoke was saved in you_said_this.txt')
        except speech_recognition.UnknownValueError:
            print("In exception")
            text = summarize(0.6)
            return text
            



def summarize(per):
    file1 = open('you_said_this.txt', 'r')
    text = file1.read()
    print(text)
    nlp = spacy.load('en_core_web_sm')
    doc= nlp(text)
    tokens=[token.text for token in doc]
    word_frequencies={}
    for word in doc:
        if word.text.lower() not in list(STOP_WORDS):
            if word.text.lower() not in punctuation:
                if word.text not in word_frequencies.keys():
                    word_frequencies[word.text] = 1
                else:
                    word_frequencies[word.text] += 1
    max_frequency=max(word_frequencies.values())
    for word in word_frequencies.keys():
        word_frequencies[word]=word_frequencies[word]/max_frequency
    sentence_tokens= [sent for sent in doc.sents]
    sentence_scores = {}
    for sent in sentence_tokens:
        for word in sent:
            if word.text.lower() in word_frequencies.keys():
                if sent not in sentence_scores.keys():                            
                    sentence_scores[sent]=word_frequencies[word.text.lower()]
                else:
                    sentence_scores[sent]+=word_frequencies[word.text.lower()]
    select_length=int(len(sentence_tokens)*per)
    summary=nlargest(select_length, sentence_scores,key=sentence_scores.get)
    final_summary=[word.text for word in summary]
    summary=''.join(final_summary)
    return summary

def main():
    x = 2
    while x!=0:
        txt = record_voice()
        print('\n\n',txt)
        if(txt):
            break
        x =- 1
if __name__ == '__main__':
    main()
