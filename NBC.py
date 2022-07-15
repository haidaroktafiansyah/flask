import pandas as pd
import re
import numpy as np
import pickle

from sklearn import model_selection
from sklearn.naive_bayes import MultinomialNB
from sklearn.metrics import classification_report
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.metrics import accuracy_score
import matplotlib.pyplot as plt
from sklearn.metrics import recall_score
from sklearn.metrics import precision_score
from sklearn.metrics import f1_score


df = pd.read_csv("./clean_data.csv")
# df.head(5)

#konversi polaritas
def convert(polarity):
  if polarity == 'positive':
    return 1
  else:
    return 0
df['Polarity'] = df['label'].apply(convert)

# print(df['label'].value_counts())
# print(df.shape)


x = df['Steaming']
y = df['Polarity'].values

bow_transformer = CountVectorizer()

# print(df['Steaming'].shape)
x = bow_transformer.fit_transform(df['Steaming'])
# print(x.toarray())
# print('Shape of Sparse Matrix: ', x.shape)
# print('Amount of Non-Zero occurences: ', x.nnz)
filename1 = './CountVectorizer.pkl'
pickle.dump(bow_transformer, open(filename1, 'wb'))

tf_transform = TfidfTransformer(use_idf=True).fit(x)
x = tf_transform.transform(x)
# density = (100.0 * x.nnz / (x.shape[0] * x.shape[1]))
# print ('Density: {}'.format((density)))
#menyimpan TFID
filename1 = './TfidfTransformer1.pkl'
pickle.dump(tf_transform, open(filename1, 'wb'))

#splitting data
x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.4)

#clasifier data1
nb = MultinomialNB()
nb.fit(x_train, y_train)
pred = nb.predict(x_test)

f1=f1_score(y_test, pred, average='weighted')
prec=precision_score(y_test, pred, average='weighted')
rec=recall_score(y_test, pred, average='weighted')
acc = accuracy_score(y_test,pred)

# print(tet)

print(classification_report(y_test,pred))
print(accuracy_score(y_test,pred))

model = MultinomialNB()
model.fit(x_train, y_train)

filename = 'model_analisis.pkl'
pickle.dump(model, open(filename, 'wb'))
# fig = plt.figure()
# ax = fig.add_axes([0,0,1,1])
# nama = ['Akurasi', 'Precision','Recall','f-measure']
# Nilai = [acc,prec,rec,f1]
# ax.bar(nama,Nilai)
# plt.show()