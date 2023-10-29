import React, { useEffect, useState } from 'react'


export default function ({ items, id, url }) {
    const [content, setContent] = useState([]);
    const [disable, setDisable] = useState(false);
    const itms = JSON.parse(items)

    useEffect(() => {
        setContent(JSON.parse(items))
    }, [])

    const updateItems = (text, target) => {
        let its = content.filter(el => el.id != target.id)
        target.valeur = text;
        its.push(target);
        setContent(its);
        console.log(content)
    }

    const send = () => {
        let empty = false
        content.forEach(el => {
            if (el.valeur == '') {
                console.log(el.valeur == '')
                empty = true
            }
        })
        if (!empty) {
            setDisable(true)
            fetch("/api/result_add/" + id, {
                method: 'POST',
                body: JSON.stringify({
                    items: content
                })
            }).then(d => d.json())
                .then(json => {
                    setDisable(false)
                    if (json.code == 200) {
                        window.location = url
                    }
                })
        } else {
            alert("un champ n'as pas été remplie")
        }
    }

    return <>
        {
            itms.map(el => {
                return <div key={el.id} className="card mb-2">
                    <div className="card-body">
                        <div className="row">
                            <label className="col-sm-2 col-form-label" htmlFor="basic-default-name">{el.nom}</label>
                            <div className="col-sm-10">
                                <input onChange={(txt) => { updateItems(txt.target.value, el); }} type="text" className="form-control" id="basic-default-name" placeholder={el.nom + " value"} />
                            </div>
                        </div>
                    </div>
                </div>
            })
        }
        <button onClick={send} disabled={content.length == 0 || disable} className="btn btn-primary">
            Send
        </button>
    </>
}