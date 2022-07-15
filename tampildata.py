import snscrape.modules.twitter as sntwitter
import pandas as pd
import predict as predictFile
import numpy as np
from flask import Flask, jsonify

df = pd.read_csv("./clean_data.csv")

app = Flask(__name__)
@app.route('/trainingDatas')
def index():
    return df.to_json(orient='records')

@app.route('/prediction')
def index2():
    data = predictFile.update()
    return data.to_json(orient='records')

app.run()